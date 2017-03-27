<?php

namespace app\controllers;

use Yii;
use app\models\TipoDocumento;
use app\models\TipoDocumentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * TipoDocumentoController implements the CRUD actions for TipoDocumento model.
 */
class TipoDocumentoController extends Controller
{
  //  public $layout = 'lay-admin-footer-fixed';
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
     * Lists all TipoDocumento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TipoDocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoDocumento model.
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
     * Creates a new TipoDocumento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TipoDocumento();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TipoDocumento model.
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
     * Deletes an existing TipoDocumento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {               
        try {
            if($this->findModel($id)->delete()){
                if (Yii::$app->getRequest()->isAjax) {
                    $dataProvider = new ActiveDataProvider([
                        'query' => TipoDocumento::find()
                    ]);
                    $searchModel = new TipoDocumentoSearch();
                    return $this->renderAjax('index', [
                       'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel
                    ]);
                }
            }
        } catch (\yii\db\IntegrityException $exc) {
//            Yii::$app->session->setFlash('error',
//                [
//                    //'type' => 'error',
//                    'icon' => 'fa fa-users',
//                    'message' => 'Localidad posee elementos relacionados',
//                    'title' => 'Error de Borrado',
//                    'positonY' => 'top',
//                    'positonX' => 'left'
//                ]                    
//            );
           // return $this->redirect(redirect(['index']);
        }        
       
        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoDocumento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TipoDocumento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoDocumento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
