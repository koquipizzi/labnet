<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Informe;
use app\models\Pago;
use app\models\PagoSearch;
use app\models\ProtocoloSearch;
use app\models\Protocolo;
use app\models\InformeNomencladorSearch;
use app\models\InformeNomenclador;
use app\models\InformeSearch;
use yii\web\Response;

/**
 * PagoController implements the CRUD actions for Pago model.
 */
class PagoController extends Controller
{
   //     public $layout = 'lay-admin-footer-fixed';
      
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
                    'createpartial'=> ['POST'],
                ],
            ],
        ];
    }

 

    /**
     * Displays a single Pago model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new PagoSearch();
        $dataProvider = $searchModel->search_informes_de_un_Pago(Yii::$app->request->queryParams,$id);  
        return $this->render('view', [
            'model' => $this->findModel($id),
             'dataProvider'=>$dataProvider,
             'searchModel'=> $searchModel,
        ]);
    }

    /**
     * Creates a new Pago model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {

        $pago = new Pago();
        $pago->fecha=date("Y-m-d");
        $searchModel = new ProtocoloSearch();
        $dataProvider = $searchModel->search_facturables(Yii::$app->request->queryParams);

        if ($pago->load(Yii::$app->request->post()) && Yii::$app->request->post("protocolo") ) {
            $arInformes= explode('"', Yii::$app->request->post("protocolo"));
            $arInformes=explode(",",$arInformes[0]);
            $count= Yii::$app->request->post("countProtocolos");
            if(count($arInformes)>strlen($count)){
                unset($arInformes[0]);     
            }
            if(strlen($count)>0){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {     
            
                $pago->save();  
                    foreach($arInformes as $protocolo=>$v){
                           $informesProtocolo= Protocolo::getAllInformes($v);
                           
                             foreach($informesProtocolo as $inf){
                                Informe::updateAll(['Pago_id'=>$pago->id], ['id'=>$inf->id]);
                            }
                     }
                     
                 $transaction->commit();
      
                }catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }

                return $this->redirect(['view',
                          'id' => $pago->id
                          ]);
                
           }
        }
         $protocolos=Yii::$app->request->post("protocolo");
        if($pago->load(Yii::$app->request->post())){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                 return ['rta'=>'error', 'message'=>'Debe seleccionar al menos un informe de la grilla.'];die();
        }

        else{ 
            return $this->render('create', [
                'model' => $pago,
                'dataProvider'=>$dataProvider,
                'searchModel'=> $searchModel
            ]);
        }
    }
    
    
  
    
    
        public function actionCreatepartial(){
            $searchModel = new ProtocoloSearch();
            $dataProvider = $searchModel->search_facturables(
                                                             Yii::$app->request->queryParams,
                                                             Yii::$app->request->post("prestadoras_id"),
                                                             Yii::$app->request->post("fechaHasta"),
                                                             Yii::$app->request->post("fechaDesde")
                                                            );
            $done=  $this->renderAjax('grilla',[
                                    'searchModel'=> $searchModel,
                                    'dataProvider'=> $dataProvider ,
                                ]);
              
            Yii::$app->response->format = Response::FORMAT_JSON;
            return array(
                        "data" => $done
                    );
              
              
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
        
        
     public function actionImpagos() {

            $searchModel = new ProtocoloSearch();
            $dataProviderEntregados = $searchModel->search_informes_impagos(Yii::$app->request->queryParams);

            return $this->render('impagos', [
                'searchModel' => $searchModel,
                'dataProvider' =>  $dataProviderEntregados,
            ]);
            
	}
        
    
    /**
     * Deletes an existing Pago model.
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
     * Finds the Pago model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pago the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pago::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
