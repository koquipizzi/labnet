<?php

namespace app\controllers;

use Yii;
use app\models\Workflow;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\controllers\InformeController;

/**
 * WorkflowController implements the CRUD actions for Workflow model.
 */
class WorkflowController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Workflow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Workflow::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Workflow model.
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
     * Creates a new Workflow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Workflow();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Workflow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
     //   var_dump($model); die();
        if ($model->load(Yii::$app->request->post())){
            if ($model->validate()) {
                // all inputs are valid
                
            } else {
                // validation failed: $errors is an array containing error messages
                
            }

            if ($model->save()) {
           return 'lpm';
               // return $this->redirect(['view', 'id' => $model->id]);
            }
                
        } else { //$errors = $model->errors; die();
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdatestados(){
        
    	$modeloinforme=Yii::$app->request->post();
    
    	$id_inf =$modeloinforme['Workflow']['Informe_id'];
    	$fecha = date_create ();
    	$fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
    	$model = new Workflow();
    	$model->fecha_inicio= $fecha;
    	
    	/*	actualiza el ultimo workflow */
        $ultimoWorkflow = Workflow::find()->where(['Informe_id' => $id_inf])->orderBy (['id' => SORT_DESC])->one();
        if(isset($ultimoWorkflow)){
            $ultimoWorkflow->fecha_fin = $fecha;
            $ultimoWorkflow->update();
        }
    	
		/** evalua si un responsable fue seteado */
		if(isset(Yii::$app->request->post('Workflow')['Responsable_id'])){
			$model->Informe_id = Yii::$app->request->post('Workflow')['Informe_id'];
			if (!empty(Yii::$app->request->post('estado'))){
                $model->Estado_id = Yii::$app->request->post('estado');
            }else{
                $model->Estado_id = Workflow::estadoEnProceso();
            }
            $model->Responsable_id =  Yii::$app->request->post('Workflow')['Responsable_id'];
            
		}else{
		    
		    if (!empty($ultimoWorkflow)){
                if ( ($ultimoWorkflow->Responsable_id == null) && ($ultimoWorkflow->Estado_id == Workflow::estadoPendiente()) ){
                    $model->Informe_id = Yii::$app->request->post('Workflow')['Informe_id'];
                    $model->Estado_id = Yii::$app->request->post('estado');
                    $model->Responsable_id =\Yii::$app->user->getId();
                
                }else if(Yii::$app->request->post('estado')){
                    $model->Informe_id = Yii::$app->request->post('Workflow')['Informe_id'];
                    $model->Estado_id = Yii::$app->request->post('estado');
                    $model->Responsable_id = $ultimoWorkflow->Responsable_id;
                }
            }
		}
        $response = 0;
		
        if($ultimoWorkflow->Estado_id != Workflow::estadoEntregado()){
            if ($model->save() && $ultimoWorkflow->Estado_id != Workflow::estadoEntregado()){
                if($model->Estado_id == Workflow::estadoEntregado()){
                    $historial = new \app\models\HistorialPaciente();
                    $historial->registrar($id_inf);
                }
                $response= ["result" => 'ok'];
                \Yii::$app->response->format = 'json';
            }else{
                $response = $model->errors;
            }
        }else{
            $response = $model->errors;
        }
       
        return $response;
    }

    /**
     * Deletes an existing Workflow model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Workflow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workflow the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workflow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
