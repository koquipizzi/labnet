<?php

namespace app\controllers;

use Yii;
use app\models\PrestadoraTemp;
use app\models\PrestadoratempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Response;
/**
 * PrestadoratempController implements the CRUD actions for PrestadoraTemp model.
 */
class PrestadoratempController extends \yii\web\Controller
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
     * Lists all PrestadoraTemp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrestadoratempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PrestadoraTemp model.
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
     * Creates a new PrestadoraTemp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PrestadoraTemp();       
        $model->Prestadora_id = Yii::$app->request->post('Prestadora_id');
        $tanda = Yii::$app->request->post('tanda');
        $model->tanda = $tanda;
        $model->nro_afiliado = Yii::$app->request->post('nro_afiliado');

        if ( $model->save()) {
            $searchModel = new PrestadoraTempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$tanda);
            $query = PrestadoraTemp::find()->where(['tanda' => $tanda]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,                                    
            ]);
            $done =  $this->renderAjax('//paciente/_grid',[
                                'dataProvider'=>$dataProvider,
                                'tanda'=>$tanda,
                                'model'=>$model
                            ]);;                                
            Yii::$app->response->format = Response::FORMAT_JSON;
            return array(
                "data" => $done,
                "tanda" => $tanda
            );
         
            return;
        } else {  
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PrestadoraTemp model.
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
     * Deletes an existing PrestadoraTemp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return; // $this->redirect(['index']);
    }

    /**
     * Finds the PrestadoraTemp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrestadoraTemp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrestadoraTemp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
