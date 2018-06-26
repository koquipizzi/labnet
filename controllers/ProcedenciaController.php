<?php

namespace app\controllers;

use Yii;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;

/**
 * ProcedenciaController implements the CRUD actions for Procedencia model.
 */
class ProcedenciaController extends Controller
{
  //  public $layout = 'lay-admin-footer-fixed';
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
     * Lists all Procedencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcedenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Procedencia model.
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
     * Creates a new Procedencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Procedencia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Procedencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Procedencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        if ($this->findModel($id)->delete()){
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'ok', 'message'=>''];die();
        }
        else {
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'error', 'message'=>''];die();
        }
    }

    /**
     * Finds the Procedencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Procedencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Procedencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
        Autor: Aller Franco
        Fecha:30/10/17
        Description: this method is used for add a procedencia in a new protocolo  
    */
    public function actionCreatepop()
    {
        $model = new Procedencia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['rta'=>'ok', 'message'=>''];
        } else {
            return $this->renderAjax('create_form_pop', [
                        'model' => $model
            ]);
        }
    }

    public function actionList($term = NULL)
    {   
        header('Content-type: application/json');
        $clean['more'] = false;

        $query = new \yii\db\Query;
        if(!empty($term)) {
            $mainQuery = $query->select('Procedencia.id
                                        ,descripcion
                                        ')
                                ->from('Procedencia')
                                ->where(['like','Procedencia.descripcion',$term])
                                ->limit(15);                       //limito a 15, para mejorar performance
            $command = $mainQuery->createCommand();
            $rows = $command->queryAll();
            $clean['results'] = array_values($rows);
        }
        echo \yii\helpers\Json::encode($clean['results']);
        exit();
    }

}
