<?php

namespace app\controllers;

use Yii;
use app\models\Workflow;

use yii\data\ActiveDataProvider;
use yii\db\Exception;
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
        $informe_id = 0;
        $nuevoEstado = 0;
        $reponsable_id = 0;
        $response = [];
        $fecha = date_create();
        $fecha = date_format($fecha, 'd-m-Y H:i:s');
        
        try{
    
            if (empty(Yii::$app->request->post())) {
                throw new Exception('No se encontro una solicitud post');
            }
    
            if (!empty(Yii::$app->request->post('Workflow')['Informe_id'])) {
                $informe_id = Yii::$app->request->post('Workflow')['Informe_id'];
            }else{
                throw new Exception('El ID del informe es obligatorio para esta accion');
            }
            
            if (!empty(Yii::$app->request->post('estado'))) {
                $nuevoEstado = Yii::$app->request->post('estado');
            }
            
            if (!empty(Yii::$app->request->post('Workflow')['Responsable_id'])){
                $reponsable_id = Yii::$app->request->post('Workflow')['Responsable_id'];
            }
    
            //Obtengo el ultimo WorkFlow para el informe
            $ultimoWorkflow = Workflow::find()->where(['Informe_id' => $informe_id])->orderBy(['id' => SORT_DESC])->one();
    
            //Seteo el fin del estado previo
            if (!empty($ultimoWorkflow)) {
                $ultimoWorkflow->fecha_fin = $fecha;
                $ultimoWorkflow->update();
            }
            
            //creo el nuevo WorkFlow debido al requirimiento post de un cambio de estado del informe
            $WorkFlowModel = new Workflow();
            $WorkFlowModel->fecha_inicio = $fecha;
            $WorkFlowModel->Informe_id = $informe_id;
    
            //Seteo el estado en el nuevo WorkFlow
            if (!empty($nuevoEstado)) {
                $WorkFlowModel->Estado_id = $nuevoEstado;
                //Si el estado previo era Pendiente y se cambio de estado se le auto asigna al usuario que realiza la accion
                if (!empty($ultimoWorkflow->Estado_id) ){
                    if ($ultimoWorkflow->Estado_id == Workflow::estadoPendiente()){
                        $WorkFlowModel->Responsable_id = \Yii::$app->user->getId();
                    }
                }
            }else{
                //Si no se seteo un nuevo estado en esta accion, le asigno el anterior
                if (!empty($ultimoWorkflow->Estado_id)){
                    $WorkFlowModel->Estado_id = $ultimoWorkflow->Estado_id;
                }
            }
    
            //Seteo el responsable en el nuevo WorkFlow
            if (!empty($reponsable_id)) {
                $WorkFlowModel->Responsable_id = $reponsable_id;
                //Si el estado del Informe era en Pendiente y se le asigno un responsable, el estado sera en proceso
                if (!empty($ultimoWorkflow->Estado_id) ){
                    if ($ultimoWorkflow->Estado_id == Workflow::estadoPendiente()){
                        $WorkFlowModel->Estado_id = Workflow::estadoEnProceso();
                    }
                }
            }else{
                //Si no se seteo el responsable  en esta accion, le asigno el anterior
                if (!empty($ultimoWorkflow->Responsable_id)){
                    $WorkFlowModel->Responsable_id = $ultimoWorkflow->Responsable_id;
                }else{
                    //Si no tenia un responsable previamente, le asigno el usuario que acciono la accion
                    $WorkFlowModel->Responsable_id = \Yii::$app->user->getId();
                }
            }
    
            if ($ultimoWorkflow->Estado_id != Workflow::estadoEntregado()) {
                if ($WorkFlowModel->save() && $ultimoWorkflow->Estado_id != Workflow::estadoEntregado()) {
                    if ($WorkFlowModel->Estado_id == Workflow::estadoEntregado()) {
                        $historial = new \app\models\HistorialPaciente();
                        $historial->registrar($informe_id);
                    }
                    if (!empty($reponsable_id)){
                        $response = ["result" => 'ok',"mensaje" => "Se cambio exitosamente el responsable del informe"];
                    }
                    if (!empty($nuevoEstado)){
                        $response = ["result" => 'ok',"mensaje" => "Se cambio exitosamente el estado del informe"];
                    }
                } else {
                    $response = $WorkFlowModel->errors;
                }
            } else {
                $response = $WorkFlowModel->errors;
            }
        }catch (Exception $e){
            $response = ["result" => "error", "mensaje" => "Se encontro un error durante el proceso"];
        }
        
        \Yii::$app->response->format = 'json';
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
