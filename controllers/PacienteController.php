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

    /**
     * Creates a new Paciente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paciente();       
        if (isset($_POST['PrestadoraTemp']['tanda']))
            $tanda = $_POST['PrestadoraTemp']['tanda'];
        else  $tanda = time();
        //var_dump($tanda);die();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $searchModel = new PrestadoratempSearch();
            $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams, $tanda);
            foreach($dataPrestadoras->getModels() as $record) {
                $pac_prest = new PacientePrestadora();
                $pac_prest->Paciente_id = $model->id;
                $pac_prest->Prestadoras_id = $record['Prestadora_id'];
                $pac_prest->nro_afiliado = $record['nro_afiliado'];
                $pac_prest->save(); 
            } 
            return $this->render('view', [
                'model' => $model,
            ]);
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
        if ($model->load(Yii::$app->request->post())){
            if ($model->validate()) {
                // all inputs are valid
            } else {
                // validation failed: $errors is an array containing error messages
                $errors = $model->errors;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
                
        } else {
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
            //    'tanda' => $tanda,                
            ]);
        }
    }
    
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
