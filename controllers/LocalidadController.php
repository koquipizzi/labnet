<?php

namespace app\controllers;

use Yii;
use app\models\Localidad;
use app\models\LocalidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;


/**
 * LocalidadController implements the CRUD actions for Localidad model.
 */
class LocalidadController extends Controller
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
     * Lists all Localidad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LocalidadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Localidad model.
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
     * Creates a new Localidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Localidad();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate_pop()
    {
        $model = new Localidad();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                     $dataProvider = new ActiveDataProvider([
                        'query' => Localidad::find()
                    ]);
                    $searchModel = new LocalidadSearch();
                    return;
        } else {
            return $this->renderAjax('_form', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Localidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $dataProvider = new ActiveDataProvider([
                        'query' => Localidad::find()
                    ]);
                    $searchModel = new LocalidadSearch();
                    return $this->render('index', [
                       'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel
                    ]);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Localidad model.
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
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Finds the Localidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Localidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Localidad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrint()
    {
       // $model = $this->findModel($id);
       $dataProvider = new ActiveDataProvider([
                        'query' => Localidad::find()

                    ]);
//        $this->render('print', [
//            'model' => $model,
//            'dataProvider' => $multimediaProvider,
//        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '* {font-size:14px}',
             // set mPDF properties on the fly

            'content' => $this->renderPartial('print', [
                             //   'searchModel' => $searchModel,
                               // 'model' => $model,
                                'dataProvider' => $dataProvider,
                            ]),
            'options' => [
                'title' => 'Acervo'
            ],
            'methods' => [
                'SetHeader' => ['Gestión de Colecciones'],
                'SetFooter' => ['|Página {PAGENO}|'],
            ]
        ]);

        return $pdf->render();
    }
}
