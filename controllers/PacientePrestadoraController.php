<?php

namespace app\controllers;

use Yii;
use app\models\PacientePrestadora;
use app\models\PacientePrestadoraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\data\ActiveDataProvider;
/**
 * PacientePrestadoraController implements the CRUD actions for PacientePrestadora model.
 */
class PacientePrestadoraController extends Controller
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
     * Lists all PacientePrestadora models.
     * @return mixed
     */
    public function actionIndex()
    {
        $Paciente_id = Yii::$app->request->post('Paciente_id');
        //die($Paciente_id);
        $searchModel = new PacientePrestadoraSearch();       
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $Paciente_id );  
        $prestadoraTemp = new PacientePrestadora();  
        $done =  $this->renderAjax('//paciente/_grid',[
                                'dataProvider'=>$dataProvider,                                
                                'model'=>$prestadoraTemp
                            ]);                               
        Yii::$app->response->format = Response::FORMAT_JSON;
        return array(
            "data" => $done,              
        );
         
       return;
//        
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }
    
    public function actionGrilla()
    { 
        $Paciente_id =Yii::$app->request->post('Paciente_id');
    //    $Paciente_id = 10;
        $query = PacientePrestadora::find()->where(['Paciente_id' => $Paciente_id]);
        $provider = new ActiveDataProvider([
            'query' => $query,                       
        ]);
        $prestadoraTemp = new PacientePrestadora();  
        $done =  $this->renderAjax('//paciente/_grid',[
                                'dataProvider'=>$provider,                                
                                'model'=>$prestadoraTemp
                            ]);                               
        Yii::$app->response->format = Response::FORMAT_JSON;
        return array(
                "data" => $done,              
            );
         
       return;
//        
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single PacientePrestadora model.
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
     * Creates a new PacientePrestadora model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    { 
        $model = new PacientePrestadora();
        $model->Prestadoras_id = Yii::$app->request->post('Prestadoras_id');
        $model->Paciente_id = Yii::$app->request->post('Paciente_id');
        $model->nro_afiliado = Yii::$app->request->post('nro_afiliado');
        $model->load(Yii::$app->request->post());

       // var_dump($model);
      //  die();
        if ($model->save()) { 
            $searchModel = new PacientePrestadoraSearch();
            $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams,$model->Paciente_id);
            $prestadoraTemp = new PacientePrestadora(); 
            $query = PacientePrestadora::find()->where(['Paciente_id' => $model->Paciente_id]);
            $dataPrestadoras = new ActiveDataProvider([
                'query' => $query,                       
            ]);
            $prestadoraTemp = new PacientePrestadora();                          
                    
            $done =  $this->renderAjax('//paciente/_grid',[
                                'dataProvider'=>$dataPrestadoras,                                
                                'model'=>$model,
                                'paciente_id' => $model->Paciente_id
                            ]);;                                
            Yii::$app->response->format = Response::FORMAT_JSON;
            return array(
                "response" => 'ok',  
                "data" => $done            
            );

        } else { 
            $errors = $model->getErrors();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return array(
                "response" => 'ko',   
                "msn" => $errors,            
            );
         
        }
    }

    /**
     * Updates an existing PacientePrestadora model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateOld($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdateNroAfiliado($id)
    {
        $rta =  ["output" => false, "message" =>'No se pudo cambiar el numero de afiliado'];
        $model = $this->findModel($id);
        if (!empty(Yii::$app->request->post('hasEditable'))){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if  (!empty($model)){
                $data = Yii::$app->request->post('nro_afiliado');
                if (!empty($data)){
                    $model->nro_afiliado = $data;
                    if ( $model->save()){
                        $rta =  ["output" => true, "message" =>'Se cambio el numero de afiliado exitosamente'];
                    }
                }
            }
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $rta;
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        elseif (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                        'model' => $model
            ]);
        } else {
            return $this->render('update', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing PacientePrestadora model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return;// $this->redirect(['index']);
    }

    /**
     * Finds the PacientePrestadora model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PacientePrestadora the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PacientePrestadora::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
