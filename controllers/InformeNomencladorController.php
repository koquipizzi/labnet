<?php

namespace app\controllers;

use app\models\Informe;
use app\models\Workflow;
use Yii;
use app\models\InformeNomenclador;
use app\models\InformeNomencladorSearch;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InformeNomencladorController implements the CRUD actions for InformeNomenclador model.
 */
class InformeNomencladorController extends Controller
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
     * Lists all InformeNomenclador models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InformeNomencladorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InformeNomenclador model.
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
     * Creates a new InformeNomenclador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {       
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new InformeNomenclador();
        $model->load(Yii::$app->request->post());
        $id_informe = (int) $model->id_informe;
        $modelInforme = Informe::find()->where(['id' => $id_informe])->one();
        if ($modelInforme->getWorkflowLastState() != Workflow::estadoEntregado()){
            $count = InformeNomenclador::find()
                ->where(['id_nomenclador' => $model->id_nomenclador, 'id_informe' => $model->id_informe])
                ->count();
            if ($count > 0){
                return array("rta" => 'no ok',"message" =>'El nomenclador ya se encuentra agregado a la práctica');
                die();
            }
    
            if ($model->save()) {
                return array("rta" => 'ok', "message" =>'Nomenclador Agregado ');
                die();
            }
        }
        
            return array("rta" => 'error',"message" =>$model->getErrors()); 
            die();
       
    }

    /**
     * Updates an existing InformeNomenclador model.
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
     * Deletes an existing InformeNomenclador model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $id_informe = (int) $model->id_informe;
        $modelInforme = Informe::find()->where(['id' => $id_informe])->one();
        if ($modelInforme->getWorkflowLastState() != Workflow::estadoEntregado()){
            if ($model->delete()){
                return array("rta" => 'success',"message" =>'El nomenclador se eliminó de la práctica');
                die();
            }
        }
        return array("rta" => 'error',"message" =>'El nomenclador no se eliminó de la práctica');
        die();
        
    }

    /**
     * Finds the InformeNomenclador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InformeNomenclador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InformeNomenclador::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
