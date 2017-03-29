<?php

namespace app\controllers;

use Yii;
use app\models\Nomenclador;
use app\models\NomencladorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * NomencladorController implements the CRUD actions for Nomenclador model.
 */
class NomencladorController extends Controller
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
     * Lists all Nomenclador models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NomencladorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nomenclador model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Nomenclador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Nomenclador();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return;// $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Nomenclador model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return;// $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Nomenclador model.
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
                        'query' => Nomenclador::find()
                    ]);
                    $searchModel = new NomencladorSearch();
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
     * Finds the Nomenclador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nomenclador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nomenclador::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
