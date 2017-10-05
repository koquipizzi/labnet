<?php

namespace app\controllers;

use Yii;
use app\models\Paciente;
use app\models\PacientePrestadora;
use app\models\PacienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Localidad;
use app\models\TipoDocumento;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use app\models\PrestadoraTemp;
use app\models\PrestadoratempSearch;
use app\models\PacientePrestadoraSearch;
use yii\data\ActiveDataProvider;
use yii\web;
use yii\base\Model;

/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class PacienteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
        ];
    }

    /**
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBuscar()
    {
        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->searchPacPrest(Yii::$app->request->queryParams);

        return $this->render('index_new_prot', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paciente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionView_modal($id)
    {
      //  if ($prest_nro == 0)
        return $this->renderAjax('viewModal', [
            'model' => $this->findModel($id)
        ]);

    }

    /**
     * Creates a new Paciente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paciente();
        $PacientePrestadorasmultiple = [new \app\models\PacientePrestadora()];
        if (isset($_POST['PrestadoraTemp']['tanda']))
            $tanda = $_POST['PrestadoraTemp']['tanda'];
        else  $tanda = time();
 
        
        if ($model->load(Yii::$app->request->post())) {
     
               if ($model->save()){
                    
                    $modelsPacientePrestadora = PacientePrestadora::createMultiple(PacientePrestadora::classname());
                    Model::loadMultiple($modelsPacientePrestadora, Yii::$app->request->post());
                    $transaction = Yii::$app->db->beginTransaction();                          
                    try {
                            $flag=true;
                            foreach ($modelsPacientePrestadora as $indexHouse => $modelPacientePrestadora) {
                                if ($flag === false) {
                                    break;
                                }

                                $modelPacientePrestadora->Paciente_id = $model->id;

                                if (!($flag = $modelPacientePrestadora->save(false))) {
                                    break;
                                } 
                            }
                            if ($flag) {
                                $transaction->commit();
                                return $this->redirect(['index']);
                            } else {
                                $transaction->rollBack();
                            }
                        } catch (Exception $e) {
                            $transaction->rollBack();
                             }
                }

           return $this->redirect(['index']);
        } else {
                $prestadoraTemp = new \app\models\PrestadoraTemp();
                $prestadoraTemp->tanda = $tanda;
                $dataLocalidad = ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
                $dataTipoDocumento = ArrayHelper::map(TipoDocumento::find()->asArray()->all(), 'id', 'descripcion');
                $pacientePrestadora = new \app\models\PacientePrestadora();

                $searchModel = new PrestadoratempSearch();
                $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams,$tanda);
                return $this->render('create', [
                    'model' => $model,
                    'dataLocalidad'=> $dataLocalidad,
                    'dataTipoDocumento'=> $dataTipoDocumento,
                    'dataPrestadoras'=> $dataPrestadoras,
                    'pacientePrestadora'=> $pacientePrestadora,
                    'prestadoraTemp'=>$prestadoraTemp,
                    'tanda' => $tanda,
                    'PacientePrestadorasmultiple'=>$PacientePrestadorasmultiple,
                ]);
        }
    }

    /**
     * Updates an existing Paciente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if(!empty(Yii::$app->request->post()['PacientePrestadora'] )){
                $arrayPacientePrestadora=Yii::$app->request->post()['PacientePrestadora']; 
            }else{
                 $arrayPacientePrestadora=null;
            }
           
          
            $modelsPrestadoras = $model->pacientePrestadoras;                      
            $oldIDs = ArrayHelper::map($modelsPrestadoras, 'id', 'id');
            $modelsPrestadoras = PacientePrestadora::createMultiple(PacientePrestadora::classname());
            Model::loadMultiple($modelsPrestadoras, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPrestadoras, 'id', 'id')));
       
            $transaction = Yii::$app->db->beginTransaction();                          
            try {
                   if ($model->save()){   
                        $flag=true;
                        if (!empty($deletedIDs)) {
                           PacientePrestadora::deleteAll(['id' => $deletedIDs]);
                        }
                        if(!empty($arrayPacientePrestadora )){   

                            foreach ($arrayPacientePrestadora as $indexHouse => $modelPacientePrestadora) {
                                $pacientePrest =  new \app\models\PacientePrestadora();
                                if ($flag === false) {
                                    break;
                                }
                                    $pacientePrest->Paciente_id = $model->id;
                                    $pacientePrest->Prestadoras_id=$modelPacientePrestadora['Prestadoras_id'];
                                    $pacientePrest->nro_afiliado=$modelPacientePrestadora['nro_afiliado'];
                                    $pacientePrest->save();    
                                
                                }
                            }
                     }
                    if ($flag) {
                        $transaction->commit();
                       return $this->redirect(['index']);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    }                                    
                        
                    return $this->render('index', [
                        'model' => $model,
                    ]);   
        }else {
            $PacientePrestadorasmultiple = PacientePrestadora::find()->where(['Paciente_id' => $id])->all();
            $searchModel = new PacientePrestadoraSearch();
            $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams,$id);
            $dataLocalidad = ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
            $dataTipoDocumento = ArrayHelper::map(TipoDocumento::find()->asArray()->all(), 'id', 'descripcion');
            $pacientePrestadora = new \app\models\PacientePrestadora();
            $prestadoraTemp = new \app\models\PrestadoraTemp();
            return $this->render('update', [
                'model' => $model,
                'dataPrestadoras' => $dataPrestadoras,
                'dataLocalidad'=> $dataLocalidad,
                'dataTipoDocumento'=> $dataTipoDocumento,
                'pacientePrestadora'=> $pacientePrestadora,
                'prestadoraTemp'=>$prestadoraTemp,
                'PacientePrestadorasmultiple'=>(empty($PacientePrestadorasmultiple)) ? [new PacientePrestadora] : $PacientePrestadorasmultiple,

            //    'tanda' => $tanda,
            ]);
    }
}

/*
 public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsPrestadoras = $model->pacientePrestadoras;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsPrestadoras, 'id', 'id');
              $modelsPrestadoras = PacientePrestadora::createMultiple(PacientePrestadora::classname());
            
            Model::loadMultiple($modelsPrestadoras, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPrestadoras, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPrestadoras) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            PacientePrestadora::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPrestadoras as $modelPrest) {
                            $modelPrest->customer_id = $model->id;
                            if (! ($flag = $modelPrest->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
          $PacientePrestadorasmultiple = PacientePrestadora::find()->where(['Paciente_id' => $id])->all();
            $searchModel = new PacientePrestadoraSearch();
            $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams,$id);
            $dataLocalidad = ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
            $dataTipoDocumento = ArrayHelper::map(TipoDocumento::find()->asArray()->all(), 'id', 'descripcion');
            $pacientePrestadora = new \app\models\PacientePrestadora();
            $prestadoraTemp = new \app\models\PrestadoraTemp();
            return $this->render('update', [
                'model' => $model,
                'dataPrestadoras' => $dataPrestadoras,
                'dataLocalidad'=> $dataLocalidad,
                'dataTipoDocumento'=> $dataTipoDocumento,
                'pacientePrestadora'=> $pacientePrestadora,
                'prestadoraTemp'=>$prestadoraTemp,
                'PacientePrestadorasmultiple'=>(empty($PacientePrestadorasmultiple)) ? [new PacientePrestadora] : $PacientePrestadorasmultiple,

            //    'tanda' => $tanda,
            ]);
    }

*/







        public function actionChequear($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())){
            if ($model->validate()) {
                // all inputs are valid
            } else {
                // validation failed: $errors is an array containing error messages
                $errors = $model->errors;
            }

            if ($model->save()) {
           return;
               // return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            $searchModel = new PacientePrestadoraSearch();
            $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams,$id);
            $dataLocalidad = ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
            $dataTipoDocumento = ArrayHelper::map(TipoDocumento::find()->asArray()->all(), 'id', 'descripcion');
            $pacientePrestadora = new \app\models\PacientePrestadora();
            $prestadoraTemp = new \app\models\PrestadoraTemp();
            return $this->renderAjax('_form_chequear', [
                'model' => $model,
                'dataPrestadoras' => $dataPrestadoras,
                'dataLocalidad'=> $dataLocalidad,
                'dataTipoDocumento'=> $dataTipoDocumento,
                'pacientePrestadora'=> $pacientePrestadora,
                'prestadoraTemp'=>$prestadoraTemp,
            //    'tanda' => $tanda,
            ]);
        }
    }


    /**
     * Deletes an existing Paciente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()){
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'ok', 'message'=>''];die();
        }
        else {
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'error', 'message'=>''];die();
        }

      //  return $this->redirect(['index']);
    }

    /**
     * Finds the Paciente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paciente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paciente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
