<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Informe;
use app\models\ProtocoloSearch;
use app\models\InformeNomencladorSearch;
use app\models\InformeNomenclador;
use app\models\InformeSearch;

/**
 * ContableController implements the CRUD actions for Contable model.
 */
class ContableController extends Controller
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
     * Displays a single Contable model.
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
     * Creates a new Contable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        $model = new Contable();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }

    public function actionUpdate($id)
    { 
            $informe =  Informe::find()->where(["id"=>$id])->one();
            $nominf = new InformeNomenclador();         
            $searchModel = new InformeNomencladorSearch();
            $informeNomenclador = new InformeNomenclador();
            $searchModel->id_informe = $id;
             $dataProvider = $searchModel->search([]);
              $modelp = $informe->protocolo;
            if (isset($_POST['hasEditable'])) {
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    $nom = $model->getNomencladorInforme($_POST['id_nom_inf']);
                    $nominf = InformeNomenclador::find()->where(['=', 'id', $nom['id']])->one();
                    $cant = $_POST['cantidad'];
                    if (is_numeric($cant)){
                            $nominf->cantidad = $_POST['cantidad'];
                            $nominf->save();
                            return ['response'=>$nominf->cantidad, 'message'=>''];
                    }
                    else {
                            return ['response'=>$nominf->cantidad, 'message'=>'Ingrese un número'];
                    }

            }
            
            return $this->renderAjax('update',[
                                       'model' => $informe, 
                                        'informe'=>$informe, 
                                        'modelp'=>$modelp,
                                        'dataProvider'=> $dataProvider,
                                        'modeloInformeNomenclador' => $informeNomenclador

                            ]);//#tab2-2 
            
    }
    
    
 
              
    /**
	 * Lists all Informe models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {

            $searchModel = new ProtocoloSearch();
            $dataProviderEntregados = $searchModel->search_informes_contables(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' =>  $dataProviderEntregados,
            ]);
            
	}
    

    /**
     * Deletes an existing Contable model.
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
     * Finds the Contable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
