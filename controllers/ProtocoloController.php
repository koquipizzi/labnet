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
use app\models\Medico;
use yii\base\Model;
//use Da\QrCode\QrCode;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use \Exception;


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
        $query = Protocolo::find()->where(['status' => 1]);
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
    
        
    public function actionCreate3($pacprest=null){ 
        $mostrarMensajeViewnNroSecuencia='';
        $pacprest_modelo = \app\models\PacientePrestadora::findOne($pacprest);      
        $paciente = Paciente::findOne($pacprest_modelo->Paciente_id);
        $prestadora = \app\models\Prestadoras::findOne($pacprest_modelo->Prestadoras_id);       
        $mdlProtocolo = new Protocolo();
        $anio=date("Y");
        $mdlProtocolo->anio=$anio;  
        $mdlProtocolo->Paciente_prestadora_id=$pacprest;
        $modelsInformes = [new Informe];
        $modelsNomenclador = [[new InformeNomenclador]];

        $fecha = date_create ();
        $fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
        if ($mdlProtocolo->load(Yii::$app->request->post())) {
                       
            if($mdlProtocolo->existeNumeroSecuencia()){
                if(!empty($mdlProtocolo->letra)){
                    try{
                        $mostrarMensajeViewnNroSecuencia="El Nro.Secuencia <strong> {$mdlProtocolo->nro_secuencia}</strong> ya existe. ";
                        $mdlProtocolo->nro_secuencia=$mdlProtocolo->getNextNroSecuenciaByLetra($mdlProtocolo->letra,$anio);
                        $mostrarMensajeViewnNroSecuencia.="El nuevo numero de secuencia es <strong>{$mdlProtocolo->nro_secuencia}</strong>.";                    
                    } catch (\Exception $e) {
                         $mdlProtocolo->nro_secuencia=sprintf("%07d",0);
                         $mostrarMensajeViewnNroSecuencia="";   
                    }
       
                } 
               
            }       
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
                        $searchModel = new InformeSearch();
                        $dataProvider = $searchModel->search((Yii::$app->request->queryParams),$mdlProtocolo->id);
                        $informe= new Informe();
                        return $this->render('view', [
                            'model' => $this->findModel($mdlProtocolo->id),
                            'dataProvider'=>$dataProvider,
                            'informe' => $informe,
                            'mostrarMensajeView'=>$mostrarMensajeViewnNroSecuencia
                        ]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');
        $mdlProtocolo->scenario = Protocolo::SCENARIO_CREATE; 
        $mdlProtocolo->fecha_entrada = date('Y-m-d');
        $pacientes = Paciente::find()->all();
        $listData = ArrayHelper::map($pacientes,'id', 'nombre');
        return $this->render('_form3', [
    //    return $this->render('_nuevo_prot', [
                            'model' => $mdlProtocolo,
                            'modelsInformes'=>(empty($modelsInformes)) ? [new Informe] : $modelsInformes,
                            'modelsNomenclador'=>(empty($modelsNomenclador)) ? [new InformeNomenclador] : $modelsNomenclador,
                            'pacprest' => $pacprest,
                            'paciente'=>$paciente,
                            'prestadora'=> $prestadora,
                            'dataMedico' => $dataMedico,
                            'listData' => $listData
                             ]);
    }


    public function actionNuevo($pacprest=null){ 
        $mostrarMensajeViewnNroSecuencia='';
        $pacprest_modelo = \app\models\PacientePrestadora::findOne($pacprest);      
        $paciente = Paciente::findOne($pacprest_modelo->Paciente_id);
        $prestadora = \app\models\Prestadoras::findOne($pacprest_modelo->Prestadoras_id);       
        $mdlProtocolo = new Protocolo();
        $anio=date("Y");
        $mdlProtocolo->anio=$anio;  
        $mdlProtocolo->Paciente_prestadora_id=$pacprest;
        $modelsInformes = [new Informe];
        $modelsNomenclador = [[new InformeNomenclador]];

        $fecha = date_create ();
        $fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
        if ($mdlProtocolo->load(Yii::$app->request->post())) {
                       
            if($mdlProtocolo->existeNumeroSecuencia()){
                if(!empty($mdlProtocolo->letra)){
                    try{
                        $mostrarMensajeViewnNroSecuencia="El Nro.Secuencia <strong> {$mdlProtocolo->nro_secuencia}</strong> ya existe. ";
                        $mdlProtocolo->nro_secuencia=$mdlProtocolo->getNextNroSecuenciaByLetra($mdlProtocolo->letra,$anio);
                        $mostrarMensajeViewnNroSecuencia.="El nuevo numero de secuencia es <strong>{$mdlProtocolo->nro_secuencia}</strong>.";                    
                    } catch (\Exception $e) {
                         $mdlProtocolo->nro_secuencia=sprintf("%07d",0);
                         $mostrarMensajeViewnNroSecuencia="";   
                    }
       
                } 
               
            }       
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
                        $searchModel = new InformeSearch();
                        $dataProvider = $searchModel->search((Yii::$app->request->queryParams),$mdlProtocolo->id);
                        $informe= new Informe();
                        return $this->render('view', [
                            'model' => $this->findModel($mdlProtocolo->id),
                            'dataProvider'=>$dataProvider,
                            'informe' => $informe,
                            'mostrarMensajeView'=>$mostrarMensajeViewnNroSecuencia
                        ]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');
        $mdlProtocolo->scenario = Protocolo::SCENARIO_CREATE; 
        $mdlProtocolo->fecha_entrada = date('Y-m-d');
        $pacientes = Paciente::find()->all();
        $listData = ArrayHelper::map($pacientes,'id', 'nombre');
    //    return $this->render('_form3', [
        return $this->render('_nuevo_prot', [
                            'model' => $mdlProtocolo,
                            'modelsInformes'=>(empty($modelsInformes)) ? [new Informe] : $modelsInformes,
                            'modelsNomenclador'=>(empty($modelsNomenclador)) ? [new InformeNomenclador] : $modelsNomenclador,
                            'pacprest' => $pacprest,
                            'paciente'=>$paciente,
                            'prestadora'=> $prestadora,
                            'dataMedico' => $dataMedico,
                            'listData' => $listData
                             ]);
    }



    /**
     * Creates a new Protocolo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *@param boolean $ajax
     *  @return mixed
     */
    public function actionProtocolo(){ 

        $mdlProtocolo = new Protocolo();
        $Estudio= new Estudio();
        $paciente= new Paciente();

        return $this->render('_nuevo_prot', [
                            'paciente' => $paciente,
                            'model' => $mdlProtocolo,
                             ]);
        
        $pacprest_modelo = \app\models\PacientePrestadora::findOne($pacprest);      
        $paciente = Paciente::findOne($pacprest_modelo->Paciente_id);
        $prestadora = \app\models\Prestadoras::findOne($pacprest_modelo->Prestadoras_id);
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
                            'informe'=>$informetemp,
                            "tanda"=>$tanda,
                             ]);

        }
        
    
       // var_dump($estudios); die();

     /*   if ($mdlProtocolo->load(Yii::$app->request->post())) {

        }*/
    }
        


    /**
     * Validates multiple models.
     * This method will validate every model. The models being validated may
     * be of the same or different types.
     * @param array $models the models to be validated
     * @param array $attributeNames list of attribute names that should be validated.
     * If this parameter is empty, it means any attribute listed in the applicable
     * validation rules should be validated.
     * @return bool whether all models are valid. False will be returned if one
     * or multiple models have validation error.
     */
    public  function validateMultiple($models, $attributeNames = null)
    {
        $valid = true;
        /* @var $model Model */
        foreach ($models as $model) {
            $valid = $model->validate($attributeNames) && $valid;
          
            if(!$model->validate($attributeNames) ){
               var_dump($model);  var_dump($model->getErrors());die(22112);
            }
        }

        return $valid;
    }

   /**

     */
    public  function addAtributo($models, $attributeNames, $val)
    {
        foreach ($models as $model) {
            $valid = $model->$attributeNames=$val;
            }        
    }



  public function actionUpdate($id)
    {
        $error='';
        $mostrarMensajeViewnNroSecuencia='';
        $model = $this->findModel($id);
        $model->nro_secuencia= str_pad((int) $model->nro_secuencia,7,"0",STR_PAD_LEFT);
        $modelsInforme=  $model->informes;
        $fecha = date_create ();
        $fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
        $anio=date("Y");
        //   var_dump(Yii::$app->request->post());die();
        if ($model->load(Yii::$app->request->post())) {
           
            if($model->existeNumeroSecuenciaUpdate()){               
                if(!empty($model->letra)){
                    try{
                        $mostrarMensajeViewnNroSecuencia="El Nro.Secuencia <strong> {$model->nro_secuencia}</strong> ya existe. ";
                        $model->nro_secuencia=$model->getNextNroSecuenciaByLetra($model->letra,$anio);
                        $mostrarMensajeViewnNroSecuencia.="El nuevo numero de secuencia es <strong>{$model->nro_secuencia}</strong>.";                    
                    } catch (\Exception $e) {
                            $model->nro_secuencia=sprintf("%07d",0);
                            $mostrarMensajeViewnNroSecuencia="";   
                    }
        
                } 
                
            }  
            //  MODELS INFORME
            $oldIDs = ArrayHelper::map($modelsInforme, 'id', 'id');
            $modelsInforme = Informe::createMultiple(Informe::classname(), $modelsInforme);
            Model::loadMultiple($modelsInforme, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsInforme, 'id', 'id')));
            // FIN MODELS INFORME

            // validate all models
            $valid = $model->validate();
            $this->addAtributo($modelsInforme,'Protocolo_id',$model->id);
            $valid = $this->validateMultiple($modelsInforme) && $valid;
            // try {
                if (!$valid) {
                    throw new \yii\base\Exception("Error,al validar el modelo protocolo.");
                }
                $transaction = \Yii::$app->db->beginTransaction();
                if (!$model->save()) {
                    throw new \yii\base\Exception("Error,save model protocolo.");
                }                 
                //DELETE INFOMES 
                if (!empty($deletedIDs)) {     
                    foreach ($deletedIDs as $key => $inf_id) {                                                                        
                        if(!Workflow::getTieneEstadoEntregado($inf_id)){
                            Informe::eliminarInforme($inf_id);
                        }                                                                     
                    }                                                                               
                }               
                foreach ($modelsInforme as $key=>$modelInforme) {       
                    //INFOMRE SAVE            
                    if (!$modelInforme->save()) {
                        throw new \yii\base\Exception("Error,save model informe");
                    }  
                    //WORKFLOW SAVE OF INFOMRE
                    $workflow= new Workflow();
                    $workflow->Informe_id= $modelInforme->id;
                    $workflow->Estado_id=1;//estado 1 es pendiente 
                    $workflow->fecha_inicio = $fecha;           
                    $workflow->save();
                    //INFOMRENOMENCLADOR OLD
                    $modelsInformeNomenclador= $modelInforme->informeNomenclador;                      
                    if(empty( $modelsInformeNomenclador)){
                        $oldIDs=array();
                    }else{
                            $oldIDs = ArrayHelper::map($modelsInformeNomenclador, 'id', 'id');
                    }                                                   
                    $modelsInformeNomenclador = informeNomenclador::createMultiple(informeNomenclador::classname(), $modelsInformeNomenclador);
                    // INFOMRENOMENCLADOR NEW  
                    if (!empty( Yii::$app->request->post()["InformeNomenclador"])       &&
                        is_array( Yii::$app->request->post()["InformeNomenclador"])     &&
                        !empty( Yii::$app->request->post()["InformeNomenclador"][$key]) &&
                        is_array(Yii::$app->request->post()["InformeNomenclador"][$key])
                        ) {
                        $arrayinformeNomencladorNew=array();   
                        foreach (Yii::$app->request->post()["InformeNomenclador"][$key] as $index => $modelNom) {
                            $informeNomenclador= new InformeNomenclador();
                            $data['InformeNomenclador'] = $modelNom;
                            $informeNomenclador->load($data);
                            $informeNomenclador->id_informe=$modelInforme->id;                                                    
                            if (!$informeNomenclador->save()) {
                                throw new \yii\base\Exception("Error,save model informeNomenclador.");
                            }
                            
                            $arrayinformeNomencladorNew[]=$informeNomenclador;
                        }
                        $arrayInformeNom=
                        ArrayHelper::toArray($arrayinformeNomencladorNew, [
                            'app\models\informeNomenclador' => [
                                'id',        
                                ]
                        ]);
                    } 
                    // END INFOMRENOMENCLADOR NEW  

                    //DELETE INFOMRENOMENCLADOR OLD
                    $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsInformeNomenclador, 'id', 'id')));                    
                    $this->addAtributo($modelsInformeNomenclador,'id_informe',$modelInforme->id);
                    if (!empty($deletedIDs)) {     
                        foreach ($deletedIDs as $key => $nomencladorId) {                                                                                                                           
                                informeNomenclador::deleteAll(["id"=>$nomencladorId]);                                            
                        }
                    }  
                                    
                } 
                    $transaction->commit();                                                                                                                     
                    // } catch (Exception $e) {
                    //     $transaction->rollBack();
                    //     $error=  "Error, update protocolo numero {$model->codigo}. {$e} ";
                    //     throw new \yii\web\HttpException(406, $error);
                    // } 
            if(empty($error)){
                $searchModel = new InformeSearch();
                $dataProvider = $searchModel->search((Yii::$app->request->queryParams),$model->id);
                $informe= new Informe();
                return $this->render('view', [
                    'model' => $this->findModel($model->id),
                    'dataProvider'=>$dataProvider,
                    'informe' => $informe,
                    'mostrarMensajeView'=>$mostrarMensajeViewnNroSecuencia
                ]);                
            }                   
        }
        $nomenclador= new Nomenclador();
        $searchModel = new InformeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $PacientePrestadora=$model->pacientePrestadoraArray;
        $modelsInformes=$model->informes;
        $model->scenario = Protocolo::SCENARIO_UPDATE; 
        return $this->render('update', [
            'model' => $model,
            'searchModel' =>$searchModel ,
            'modelsInformes' => (empty($modelsInformes)) ? [new Informe] : $modelsInformes,
            'dataProvider' => $dataProvider,
            'nomenclador'=>$nomenclador,
            'PacientePrestadora'=>$PacientePrestadora
        ]);

    }











    // /**
    //  * Updates an existing Protocolo model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);
    //     $nomenclador= new Nomenclador();
    //     $searchModel = new InformeSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } 
    //     else
    //     { 
    //         $PacientePrestadora=$model->pacientePrestadoraArray;
    //         $modelsInformes=$model->informes;
    //         return $this->render('update', [
    //             'model' => $model,
    //             'searchModel' =>$searchModel ,
    //             'modelsInformes' => (empty($modelsInformes)) ? [new Informe] : $modelsInformes,
    //             'dataProvider' => $dataProvider,
    //             'nomenclador'=>$nomenclador,
    //             'PacientePrestadora'=>$PacientePrestadora
    //         ]);
    //     }
    // }

    /**
     * Deletes an existing Protocolo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {   
           
        $respuesta='ok';
        $msj='';
        $protocolo=$this->findModel($id);
        try{
        //    if($protocolo->tieneInformesEntregados()[0] == true){
        //         throw new Exception("No se peude eliminar, el protocolo tiene informes  ");
        //    }
            $protocolo->tieneInformesEntregados();
            $protocolo->eliminarInformes();            
            $pdeleted=$protocolo->delete();            
        }catch (\Exception $e) {
            $respuesta='error';
            $msj="El protocolo no pudo eliminarse. Esto puede ser causa de que los informes del mismo ya fueron modificados.";
        }       
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['rta'=>$respuesta,"msj"=>$msj];
        

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

    public function actionNroSecuenciaLetra()
    {
        $rta=false;   
        $nro_secuencia=sprintf("%07d",0);
        $mensaje="";
        $modelProtocolo=new Protocolo();
        try{
            if ( !empty(Yii::$app->request->post()["letra"]) && !empty(Yii::$app->request->post()["anio"]) )  {
                $letra          =Yii::$app->request->post()["letra"];
                $anio           =Yii::$app->request->post()["anio"];
                $nro_secuencia  =$modelProtocolo->getNextNroSecuenciaByLetra($letra,$anio);
                $rta            =true;
            }
        } catch (\Exception $e) {
            $mensaje=$e->getMessage();
        }
       
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['rta'=>$rta,"nro_secuencia"=>$nro_secuencia,"mensaje"=>$mensaje];
    }
    
    public function actionNroSecuenciaLetraUpdate()
    {
        $rta=false;
        $nro_secuencia=sprintf("%07d",0);
        $mensaje="";
        $modelProtocolo=new Protocolo();
        try{
            if ( !empty(Yii::$app->request->post()["letra"]) && !empty(Yii::$app->request->post()["anio"]) )  {
                $letra          =Yii::$app->request->post()["letra"];
                $anio           =Yii::$app->request->post()["anio"];
                $nro_secuencia  =$modelProtocolo->getNextNroSecuenciaByLetra($letra,$anio);
                $rta            =true;
            }
        } catch (\Exception $e) {
            $mensaje=$e->getMessage();
        }
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['rta'=>$rta,"nro_secuencia"=>$nro_secuencia,"mensaje"=>$mensaje];
    }

    public function actionExisteNroSecuenciaLetra()
    {

        $rta=false;    
        $mensaje="";   
        $mensajeError=""; 
        try{
            if( empty(Yii::$app->request->post()["letra"]) || empty(Yii::$app->request->post()["anio"]) || empty(Yii::$app->request->post()["nro_secuencia"])  ){
                throw new \yii\base\Exception("the request especification is wrong ");         
            }            
            $letra          = Yii::$app->request->post()["letra"];
            $anio           = Yii::$app->request->post()["anio"];
            $nro_secuencia  = Yii::$app->request->post()["nro_secuencia"];
            $rta            = Protocolo::existeNumeroSecuenciaParams($anio,$letra,$nro_secuencia);
        } catch (\Exception $e) {
            $mensajeError=$e->getMessage();
        }
        if($rta){
            $mensaje="El nro de secuencia {$nro_secuencia} para la letra {$letra} ya existe.";
        }
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['rta'=>$rta,"mensaje"=>$mensaje,"mensajeError"=> $mensajeError];
    }
    
    
    
    
    public function actionExisteNroSecuenciaLetraUpdate()
    {

        $rta=false;    
        $mensaje="";   
        $mensajeError=""; 
        try{
            if( empty(Yii::$app->request->post()["letra"]) || empty(Yii::$app->request->post()["anio"]) || empty(Yii::$app->request->post()["nro_secuencia"]) || empty(Yii::$app->request->post()["protocolo_id"])   ){
                throw new \yii\base\Exception("the request especification is wrong ");         
            }            
            $letra          = Yii::$app->request->post()["letra"];
            $anio           = Yii::$app->request->post()["anio"];
            $nro_secuencia  = Yii::$app->request->post()["nro_secuencia"];
            $protocolo_id  = Yii::$app->request->post()["protocolo_id"];
            $rta            = Protocolo::existeNumeroSecuenciaParamsUpdate($anio,$letra,$nro_secuencia,$protocolo_id);
        } catch (\Exception $e) {
            $mensajeError=$e->getMessage();
        }
        if($rta){
            $mensaje="El nro de secuencia {$nro_secuencia} para la letra {$letra} ya existe.";
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['rta'=>$rta,"mensaje"=>$mensaje,"mensajeError"=> $mensajeError];
    }
    
    public function actionCambioLetra()
    {
        $rta=false;
        $mensaje="";
        $mensajeError="";
        $modelProtocolo= new Protocolo();
        try{
            if( empty(Yii::$app->request->post()["letra"]) || empty(Yii::$app->request->post()["anio"]) || empty(Yii::$app->request->post()["nro_secuencia"]) || empty(Yii::$app->request->post()["protocolo_id"])   ){
                throw new \yii\base\Exception("the request especification is wrong ");
            }
            $letra          = Yii::$app->request->post()["letra"];
            $anio           = Yii::$app->request->post()["anio"];
            $nro_secuencia  = Yii::$app->request->post()["nro_secuencia"];
            $protocolo_id  = Yii::$app->request->post()["protocolo_id"];
            $rowProtocolo  = Protocolo::find()->where(["letra"=>$letra,"anio"=>$anio,"id"=>$protocolo_id])->one();
         
            if(!empty($rowProtocolo)){
                $nro_secuencia= $nro_secuencia=sprintf("%07d",$rowProtocolo->nro_secuencia);
            }else{
                $nro_secuencia=$modelProtocolo->getNextNroSecuenciaByLetra($letra,$anio);
            }
            $rta            =true;
        } catch (\Exception $e) {
            $nro_secuencia= $nro_secuencia=sprintf("%07d",0);
            $mensajeError=$e->getMessage();
        }
    
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['rta'=>$rta,"nro_secuencia"=>$nro_secuencia,"mensaje"=>$mensajeError];
    }

}

