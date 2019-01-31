<?php

namespace app\controllers;

use Yii;
use app\models\Leyenda;
use app\models\LeyendaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LeyendaController implements the CRUD actions for Leyenda model.
 */
class LeyendaController extends Controller
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
     * Lists all Leyenda models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeyendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Leyenda model.
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
     * Creates a new Leyenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Leyenda();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Leyenda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
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

    /**
     * Deletes an existing Leyenda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {        
        if ($this->findModel($id)->delete()){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['rta'=>'true', 'message'=>''];die();
        }
        else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['rta'=>'false', 'message'=>''];die();

        }
    }

    /**
     * Finds the Leyenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Leyenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Leyenda::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExisteCodigo()
    {
        $rta = false;    
        $message = "";
        $messageUser = "";
        if(is_array(Yii::$app->request->post()) && array_key_exists('codigo',Yii::$app->request->post())  && array_key_exists('categoria',Yii::$app->request->post()) && array_key_exists('leyendaId',Yii::$app->request->post())){
            $codigo = Yii::$app->request->post()['codigo'];
            $categoria = Yii::$app->request->post()['categoria'];
            $leyendaId = Yii::$app->request->post()['leyendaId'];
            try{
                if ( empty($codigo) || empty( $categoria) ) {
                    throw new \yii\base\Exception("the especification request is wrong ");         
                }                        
                $rta = Leyenda::existeCodigo($codigo,$categoria,$leyendaId);
                if($rta){
                    $messageUser = "EL código '{$codigo}' existe para la categoria '{$categoria}'";
                }
            }catch (\Exception $e) {
                $rta = false; 
                $message = "Error, al comprobar existencia de código.".$e->getMessage()();
            }
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['rta'=> $rta, 'memessageExeption'=>$message,'messageUser'=>$messageUser];
        
    }
}
