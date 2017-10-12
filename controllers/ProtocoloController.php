<?php

namespace app\controllers;
use app\models\InformeNomenclador;
use app\models\NroSecuenciaProtocolo;
use app\models\Workflow;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Nomenclador;
use app\models\Protocolo;
use app\models\InformeNomencladorTemporal;
use app\models\ProtocoloSearch;
use app\models\InformeTempSearch;
use app\models\InformeSearch;
use app\models\Estudio;
use \app\models\Informe;
use app\models\InformeTemp;
use app\models\Paciente;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;
use app\models\User;
use yii\base\Model;
use Da\QrCode\QrCode;
use yii\web\Response;
use yii\helpers\Url;


/**
 * ProtocoloController implements the CRUD actions for Protocolo model.
 */
class ProtocoloController extends Controller
{
   // public $layout = 'lay-admin-footer-fixed';
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
     * Lists all Protocolo models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new ProtocoloSearch();
        $searchModelAsig = new ProtocoloSearch();

        $params = Yii::$app->request->queryParams;
        $params['ProtocoloSearch']['estado_id'] = 1;

        $dataProvider = $searchModel->searchPendiente($params);
        $loggedUserId = Yii::$app->user->id;
        return $this->render('index_pendientes', [
            'searchModel' => $searchModel,
            'searchModelAsig' => $searchModelAsig,
            'dataProvider' => $dataProvider,

        ]);
    }

    /*public function actions()
    {
        return [
            'qr' => [
                'class' => QrCodeAction::className(),
                'text' => 'https://2amigos.us',
                'param' => 'v',
                'commponent' => 'qr' // if configured in our app as `qr` 
            ]
        ];
    }*/

    public function actionQrCode($id) {
        $qr = Yii::$app->get('qr');
        //  var_dump($qr); die();
          Yii::$app->response->format = Response::FORMAT_RAW;
          Yii::$app->response->headers->add('Content-Type', $qr->getContentType());
        $text =   Url::to(['/informe/update', 'id' => $id]);
        return $qr
              ->setText($text)
              ->setLabel($id)
              ->writeString();
        //return QrCode::png2wbmp( Yii::$app->getRequest()->getQueryParam('id'),  false, Enum::QR_ECLEVEL_L, 8, 4, true );
    }
    
    
    /**
     * Lists all Protocolo Asignados.
     * @return mixed
     */
    public function actionAsignados()
    {
        $searchModelAsig = new ProtocoloSearch();
        $loggedUserId = Yii::$app->user->id;
        $dataProvider_asignados = $searchModelAsig->search_asignados($loggedUserId,Yii::$app->request->queryParams);

        return $this->render('index_asignados', [
            'searchModelAsig' => $searchModelAsig,
            'dataProvider_asignados' =>  $dataProvider_asignados,
        ]);
    }
    
        /**
     * Lists all Protocolo Asignados.
     * @return mixed
     */
    public function actionTerminados()
    {
        $searchModel = new ProtocoloSearch();
        $dataProviderTerminados = $searchModel->search_terminados(Yii::$app->request->queryParams);

        return $this->render('index_terminados', [
            'searchModel' => $searchModel,
            'dataProvider_terminados' =>  $dataProviderTerminados,
        ]);
    }
    
    public function actionEntregados()
    {
        $searchModel = new ProtocoloSearch();
        $dataProviderEntregados = $searchModel->search_entregados(Yii::$app->request->queryParams);

        return $this->render('index_entregados', [
            'searchModel' => $searchModel,
            'dataProvider_entregados' =>  $dataProviderEntregados,
        ]);
    }

    /**
     * Displays a single Protocolo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new InformeSearch();
        $dataProvider = $searchModel->search((Yii::$app->request->queryParams),$id);
        $informe= new Informe();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider'=>$dataProvider,
            'informe' => $informe,
        ]);
    }
    
        /**
     * get all protocols
     *@author franco.e 
     * @param integer $id
     * @return mixed
     */
    public function actionAll()
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM Protocolo ')->queryScalar();

        $provider = new SqlDataProvider([
            'sql' => 'SELECT * FROM Protocolo ',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'attributes' => [
                    'title',
                    'view_count',
                    'created_at',
                ],
            ],
        ]);

        $models = $provider->getModels();

        $searchModel = new ProtocoloSearch();
        $dataProvider = $searchModel->searchTodos(Yii::$app->request->queryParams);
        $loggedUserId = Yii::$app->user->id;
        $dataProviderTodosLosProtocolos= $searchModel->searchTodos(Yii::$app->request->queryParams);
        //pendientes 
        $query = Protocolo::find()->where(['status' => 1]);
//var_dump( $query);die();
        return $this->render('_all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderTodosLosProtocolos'=>$dataProviderTodosLosProtocolos
        ]);

    }
    
 
    /**
     * Define si protocolo tiene todos los informes pendientes
     *@param boolean $ajax
     *  @return mixed
     */
     public function tienePendientes($id)
    {
        $model = $this->findModel($id);
        $ret = false;
        foreach ($model->informes as $inf){
           // $val = $val.$inf->estudio->nombre." "; 
            $estado = $inf->workflowLastState;
            if (($estado == 5) || ($estado == 6))
                $ret = true;                     
        }
        return $ret;
        
    }
    

    /**
     * Creates a new Protocolo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *@param boolean $ajax
     *  @return mixed
     */
    public function actionCreate(){        
        $mdlProtocolo = new Protocolo();
        $modelSecuencia= new NroSecuenciaProtocolo();
        $Estudio= new Estudio();
        $informetemp= new Informetemp();
        
        $fecha = date_create ();
        $fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
        $modelSecuencia->fecha=date("Y-m-d");

        if ($mdlProtocolo->load(Yii::$app->request->post())) {
            $modelSecuencia->save();
            $secuencia=sprintf("%06d", $modelSecuencia->secuencia);
            $mdlProtocolo->nro_secuencia=$secuencia;
            $idSession=Yii::$app->session->getId();
            $tanda=Yii::$app->request->post()['tanda'];
            $informesTemp=InformeTemp::find()
            		->where([
                                'session_id' => $idSession,
                                'tanda'=>$tanda
                     ])->all();            
            if(empty($informesTemp)===false){
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {     
                    $fechaEntrada = date("Y-m-d"); 
                    $mdlProtocolo->fecha_entrada = $fechaEntrada;
                    $mdlProtocolo->save();
                    foreach ($informesTemp as $objeto=>$mdl){   
                        $informe= new Informe();
                      //  var_dump($informe); die();
                        $workflow= new Workflow();
                        foreach ($informe as $k=>$v){
                            if($k != 'id'){  
                                if ($k != 'id_old')
                                $informe[$k]= $mdl[$k];
                            }
                        } //die();
                        $edad= $mdlProtocolo->getPacienteEdad();
                        $informe->edad= $edad;
                        $informe->Protocolo_id= $mdlProtocolo->id;
                        $informe->titulo= $informe->estudio->titulo;
                        $informe->save();
                       // var_dump($informe); die();
                        $workflow->Informe_id= $informe->id;
                        $workflow->Estado_id=1;//estado 1 es pendiente 
                        $workflow->fecha_inicio = $fecha;
                        $workflow->save();
                        $nomencladoresPorInforme= InformeNomencladorTemporal::find()
                        							->where([
                                                    	   	'id_informeTemp' => $mdl->id,
                                                      		])->all();

                        foreach ($nomencladoresPorInforme as $obj=>$mdlNomenclador) {
                            $informeNomenclador= new InformeNomenclador();
                            $informeNomenclador->id_nomenclador=$mdlNomenclador->id_nomenclador;
                            $informeNomenclador->id_informe=$informe->id;
                            $informeNomenclador->save();
                        }
                    }                             
                    $transaction->commit();
                } 
                catch (\Exception $e) {
                            $transaction->rollBack();
                            throw $e;
                } 
                Yii::$app->response->redirect(['protocolo/view','id' => $mdlProtocolo->id]);
            }else {
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'error', 'message'=>''];die();
                }
        }
        else {
            $tanda=time();
            Yii::$app->session->set('tanda', $tanda);
            $nomenclador= new Nomenclador();
            $searchModel = new InformeTempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $tanda);
            $fechaEntrada= date("d-m");
            $anio= date("Y");
            $mdlProtocolo->fecha_entrada= $fechaEntrada;
            $mdlProtocolo->anio=$anio;
            $mdlProtocolo->letra="A";
         //   var_dump($mdlProtocolo); die();
            return $this->render('create', [
                            'model' => $mdlProtocolo,
                            'searchModel' =>$searchModel ,
                            'Estudio' => $Estudio,
                            'dataProvider' => $dataProvider,
                            'informe'=>$informetemp,
                            'nomenclador'=>$nomenclador,
                            'tanda'=>$tanda,
                             ]);
        }
    }
        
    public function actionCreate3($pacprest=null){ 
        $pacprest_modelo = \app\models\PacientePrestadora::findOne($pacprest);      
        $paciente = Paciente::findOne($pacprest_modelo->Paciente_id);
        $prestadora = \app\models\Prestadoras::findOne($pacprest_modelo->Prestadoras_id);       
        $mdlProtocolo = new Protocolo();
        $modelSecuencia= new NroSecuenciaProtocolo();
        $modelSecuencia->fecha= date("Y-m-d");
        $modelSecuencia->save();
        $modelSecuencia->refresh();
        $secuencia= $modelSecuencia->secuencia;   
        $secuencia=sprintf("%06d", $secuencia);
        $mdlProtocolo->nro_secuencia=$secuencia;
        $mdlProtocolo->Paciente_prestadora_id=$pacprest;
        $modelsInformes = [new Informe];
        $modelsNomenclador = [[new InformeNomenclador]];

        $fecha = date_create ();
        $fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
        if ($mdlProtocolo->load(Yii::$app->request->post())) {       
            if ($mdlProtocolo->fecha_entrada == NULL)
                $mdlProtocolo->fecha_entrada = date("Y-m-d");
            $modelsInformes = Informe::createMultiple(Informe::classname());
            Model::loadMultiple($modelsInformes, Yii::$app->request->post());
            $valid = $mdlProtocolo->validate();
            if (!empty($_POST['InformeNomenclador'])  && is_array($modelsNomenclador) ) {
                foreach ($_POST['InformeNomenclador'] as $indexInforme => $nomencladores) {
                    foreach ($nomencladores as $index => $nom) {
                        $data['InformeNomenclador'] = $nom;
                        $modelInformeNomenclador = new InformeNomenclador;
                        $modelInformeNomenclador->load($data);
                        $modelsNomenclador['informe_nom'][$indexInforme][$index] = $modelInformeNomenclador;
                    }
                }
            }
            else $modelsNomenclador = null;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $mdlProtocolo->save(false)) {
                        // model informe 
                        foreach ($modelsInformes as $indexHouse => $modelInforme) {
                            if ($flag === false) {
                                break;
                            }

                            $modelInforme->Protocolo_id = $mdlProtocolo->id;

                            if (!($flag = $modelInforme->save(false))) {
                                break;
                            }
                            $workflow= new Workflow();
                            $workflow->Informe_id= $modelInforme->id;
                            $workflow->Estado_id=1;//estado 1 es pendiente 
                            $workflow->fecha_inicio = $fecha;           
                            $workflow->save();
                            if (!empty($modelsNomenclador) && is_array($modelsNomenclador) &&  array_key_exists('informe_nom',$modelsNomenclador) && array_key_exists($indexHouse,$modelsNomenclador['informe_nom'])
                             ) {
                                foreach ($modelsNomenclador['informe_nom'][$indexHouse] as $index => $modelNom) {
                                    $informeNomenclador= new InformeNomenclador();
                                    $informeNomenclador->id_informe=$modelInforme->id;
                                    $informeNomenclador->id_nomenclador=$modelNom->id_nomenclador;
                                    $informeNomenclador->cantidad = $modelNom->cantidad;
                                    $informeNomenclador->save();
                                  
                                    if (!($flag = $informeNomenclador->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $mdlProtocolo->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

       
          
        return $this->render('_form3', [
                            'model' => $mdlProtocolo,
                            'modelsInformes'=>(empty($modelsInformes)) ? [new Informe] : $modelsInformes,
                            'modelsNomenclador'=>(empty($modelsNomenclador)) ? [new InformeNomenclador] : $modelsNomenclador,
                            'pacprest' => $pacprest,
                            'paciente'=>$paciente,
                            'prestadora'=> $prestadora
                             ]);
    }


    public function actionCreate2($pacprest=null){ 
      /*  $session = Yii::$app->session;
        $session->open();
         $idSession=Yii::$app->session->getId();
            var_dump(Yii::$app->session->getId()); die();*/
        $pacprest_modelo = \app\models\PacientePrestadora::findOne($pacprest);      
        $paciente = Paciente::findOne($pacprest_modelo->Paciente_id);
        $prestadora = \app\models\Prestadoras::findOne($pacprest_modelo->Prestadoras_id);       
        $mdlProtocolo = new Protocolo();
        $modelSecuencia= new NroSecuenciaProtocolo();
        $modelSecuencia->fecha= date("Y-m-d");
        $modelSecuencia->save();
        $modelSecuencia->refresh();
        $secuencia = $modelSecuencia->secuencia;
        $mdlProtocolo->nro_secuencia=$secuencia;   
        $secuencia=sprintf("%06d", $secuencia);
        $mdlProtocolo->nro_secuencia=$secuencia;

        $Estudio= new Estudio();
        $informetemp= new Informetemp();
        
        $fecha = date_create ();
        $fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
       
        if ($mdlProtocolo->load(Yii::$app->request->post())) {
            $idSession=Yii::$app->session->getId();
            $tanda=Yii::$app->request->post()['tanda'];
            
            $informesTemp=InformeTemp::find()
            		->where([
                     //          'session_id' => $idSession,
                                'tanda'=>$tanda
                     ])->all();      
            if(empty($informesTemp)===false){ 
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {     
                    $fechaEntrada = date("Y-m-d"); 
                    $mdlProtocolo->fecha_entrada = $fechaEntrada;
                    $mdlProtocolo->Paciente_prestadora_id = $pacprest;
                    $mdlProtocolo->save();
                 //   var_dump($mdlProtocolo); die();
                    foreach ($informesTemp as $objeto=>$mdl){   
                        $informe= new Informe();
                      //  var_dump($informe); die();
                        $workflow= new Workflow();
                        foreach ($informe as $k=>$v){
                            if($k != 'id'){  
                                if ($k != 'id_old')
                                $informe[$k]= $mdl[$k];
                            }
                        } //die();
                        $edad= $mdlProtocolo->getPacienteEdad();
                        $informe->edad= $edad;
                        $informe->Protocolo_id= $mdlProtocolo->id;
                        $informe->titulo= $informe->estudio->titulo;
                        $informe->save();
                       // var_dump($informe); die();
                        $workflow->Informe_id= $informe->id;
                        $workflow->Estado_id=1;//estado 1 es pendiente 
                        $workflow->fecha_inicio = $fecha;
                        $workflow->save();
                        $nomencladoresPorInforme= InformeNomencladorTemporal::find()
                        							->where([
                                                    	   	'id_informeTemp' => $mdl->id,
                                                      		])->all();

                        foreach ($nomencladoresPorInforme as $obj=>$mdlNomenclador) {
                            $informeNomenclador= new InformeNomenclador();
                            $informeNomenclador->id_nomenclador=$mdlNomenclador->id_nomenclador;
                            $informeNomenclador->id_informe=$informe->id;
                            $informeNomenclador->save();
                        }
                    }                             
                    $transaction->commit();
                } 
                catch (\Exception $e) {
                            $transaction->rollBack();
                            throw $e;
                }
                Yii::$app->response->redirect(['protocolo/view','id' => $mdlProtocolo->id]);
            }else { //se deben agregar estudios 
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'error', 'message'=>''];die();
                }
        }
        else {
            $tanda=time();
            Yii::$app->session->set('tanda', $tanda);
            $nomenclador= new Nomenclador();
            $searchModel = new InformeTempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $tanda);
            $fechaEntrada= date("d-m");
            $anio= date("Y");
            $mdlProtocolo->fecha_entrada= $fechaEntrada;
            $mdlProtocolo->anio=$anio;
            $mdlProtocolo->letra="A";
            $informetemp->session_id = Yii::$app->session->getId();
            return $this->render('create', [
                            'model' => $mdlProtocolo,
                            'searchModel' =>$searchModel ,
                            'Estudio' => $Estudio,
                            'dataProvider' => $dataProvider,
                            'informe'=>$informetemp,
                            'nomenclador'=>$nomenclador,
                            'tanda'=>$tanda,
                            'pacprest' => $pacprest,
                            'paciente'=>$paciente,
                            'prestadora'=> $prestadora
                             ]);
        }
    }


    /**
     * Creates a new Protocolo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *@param boolean $ajax
     *  @return mixed
     */
    public function actionProtocolo($pacprest=null){ 
     //   $pacprest = 74454;
        $pacprest_modelo = \app\models\PacientePrestadora::findOne($pacprest);      
        $paciente = Paciente::findOne($pacprest_modelo->Paciente_id);
        $prestadora = \app\models\Prestadoras::findOne($pacprest_modelo->Prestadoras_id);
//       var_dump($prestadora); die();
        $mdlProtocolo = new Protocolo();
        $modelSecuencia= new NroSecuenciaProtocolo();
        $Estudio= new Estudio();
        $informetemp= new Informetemp();
        
        $fecha = date_create();
        $fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
        $modelSecuencia->fecha=date("Y-m-d");
        $estudios = $_POST['InformeTemp']['Estudio_id'];
        $fechaEntrada = date("Y-m-d");

        if ($mdlProtocolo->load(Yii::$app->request->post())) {
            $modelSecuencia->save();
            $secuencia=sprintf("%06d", $modelSecuencia->secuencia);
            $mdlProtocolo->nro_secuencia=$secuencia;
            $mdlProtocolo->Paciente_prestadora_id = $pacprest;
            if ($mdlProtocolo->fecha_entrada == ""){
                $mdlProtocolo->fecha_entrada = $fechaEntrada;
            }
            if(empty($estudios)===false){
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {     
                    $mdlProtocolo->save();
                    foreach ($estudios as $estudio_id){   
                        $informe= new Informe();
                        $workflow= new Workflow();
                        $informe->Estudio_id = $estudio_id;
                        $edad= $mdlProtocolo->getPacienteEdad();
                        $informe->edad= $edad;
                        $informe->Protocolo_id= $mdlProtocolo->id;
                        $informe->titulo= $informe->estudio->titulo;
                        $informe->save();

                        $workflow->Informe_id= $informe->id;
                        $workflow->Estado_id=1;//estado 1 es pendiente 
                        $workflow->fecha_inicio = $fecha;
                        $workflow->save();
                    }                             
                    $transaction->commit();
                } 
               catch (\Exception $e) {
                            $transaction->rollBack();
                            throw $e;
                }
                $searchModel = new InformeSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $mdlProtocolo->id);
                $nomenclador= new Nomenclador();
                $infnomenclador = new InformeNomenclador();
                 $informetemp= new Informetemp();
                return $this->render('_view_protocolo', [
                            'paciente' => $paciente,
                            'prestadora'=> $prestadora,
                            'pacprest' => $pacprest,
                            'model' => $mdlProtocolo,
                            'searchModel' =>$searchModel ,
                            'Estudio' => $Estudio,
                            'dataProvider' => $dataProvider,
                            'informe'=>$informetemp,
                            'nomenclador'=>$nomenclador,
                            'infnomenclador'=>$infnomenclador,
                        //    'dataProviderIN'=> $dataProviderIN,
                            "tanda"=>$tanda,
                             ]);
                  }
        }
        else {
            $anio= date("Y");
            $mdlProtocolo->fecha_entrada= $fechaEntrada;
            $secuencia=sprintf("%06d", $modelSecuencia->secuencia);
            $mdlProtocolo->nro_secuencia=$secuencia;
            $mdlProtocolo->anio=$anio;
            $mdlProtocolo->letra="A";
            return $this->render('_form_protocolo', [
                            'paciente' => $paciente,
                            'prestadora'=> $prestadora,
                            'pacprest' => $pacprest,
                            'model' => $mdlProtocolo,
                            'searchModel' =>$searchModel ,
                            'Estudio' => $Estudio,
                       //     'dataProvider' => $dataProvider,
                            'informe'=>$informetemp,
                    //        'nomenclador'=>$nomenclador,
                            "tanda"=>$tanda,
                             ]);

        }
        
    
       // var_dump($estudios); die();

     /*   if ($mdlProtocolo->load(Yii::$app->request->post())) {

        }*/
    }
        

    /**
     * Updates an existing Protocolo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nomenclador= new Nomenclador();
        $Estudio= new Estudio();
        $searchModel = new InformeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $informe= new Informe();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
            return $this->renderAjax('update', [
                'model' => $model,
                'searchModel' =>$searchModel ,
                'dataProvider' => $dataProvider,
                'informe'=>$informe,
                'nomenclador'=>$nomenclador,
            ]);
        }
    }

    /**
     * Deletes an existing Protocolo model.
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
     * Finds the Protocolo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Protocolo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Protocolo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

