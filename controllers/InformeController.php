<?php

namespace app\controllers;

use Yii;
use app\models\Informe;
use app\models\Protocolo;
use app\models\Laboratorio;
use app\models\InformeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use yii\helpers\BaseFileHelper;
use app\models\Nomenclador;
use app\models\Multimedia;
use yii\web\UploadedFile;
use app\models\InformeNomencladorSearch;
use app\models\InformeNomenclador;
use app\models\Workflow;
use kartik\mpdf\Pdf;
use app\components\TagBehavior;
/**
 * InformeController implements the CRUD actions for Informe model.
 */
class InformeController extends Controller {
//	public $layout = 'lay-admin-footer-fixed';
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
	return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'POST'
                    ]
                ]
            ]
        ];
    }
	
	/**
	 * Lists all Informe models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
            $query = Informe::find ()->where ( [ 
                'Protocolo_id' => 1 
            ] );

            $provider = new ActiveDataProvider ( [ 
                'query' => $query,
                'pagination' => [ 
                                'pageSize' => 10 
                ] 
            ] );

            $searchModel = new InformeSearch ();
            $dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
            return $this->render ( 'index', [ 
                            'searchModel' => $dataProvider,
                            'dataProvider' => $provider 
            ] );
	}
	
	/**
	 * Displays a single Informe model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
            $model=$this->findModel($id);
             if ($model->estudio->nombre === 'PAP') {
				return $this->render('view_informe_modal_pap', [
						'model' => $model,
			]);
             }else{
                 return $this->render('view_informe_modal', [
				'model' => $model,
                     ]);
             }
	}
	
	/**
	 * Displays a single Informe para el modal
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionViewInf($id) {
            return $this->renderAjax ( 'view_informe_modal', [ 
                            'model' => $this->findModel ( $id ) 
            ] );
	}
	
	/**
	 * Creates a new Informe model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
            $model = new Informe ();

            if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
                    return $this->redirect ( [ 
                                    'view',
                                    'id' => $model->id 
                    ] );
            } else {
                    return $this->renderAjax ( 'create', [ 
                                    'model' => $model 
                    ] );
            }
	}
	
        public function cargarModelo(&$model, $texto) {
			
            switch ($model->estudio->id){
                case 1: //pap
                    $model->material = $texto->material;
                    $model->tecnica = $texto->tecnica;
                    $model->citologia = $texto->micro;
                    $model->diagnostico = $texto->diagnos;
                    $model->observaciones = $texto->observ;
		//			var_dump($model); die();
                    break;
                case 2: //biopsia
                    $model->material = $texto->material;
                    $model->tecnica = $texto->tecnica;
                    $model->macroscopia = $texto->macro;
                    $model->microscopia = $texto->micro;
                    $model->diagnostico = $texto->diagnos;
                    $model->observaciones = $texto->observ;
                    break;
                case 3: //molecular
                    $model->material = $texto->material;
                    $model->tecnica = $texto->tecnica;
                    $model->macroscopia = $texto->macro;
                    $model->microscopia = $texto->micro;
                    $model->diagnostico = $texto->diagnos;
                    $model->observaciones = $texto->observ;
                    break;
                case 4: //citologia
                    $model->tipo = $texto->macro;
                    $model->tecnica = $texto->tecnica;
                    $model->material = $texto->material;
                    $model->descripcion = $texto->micro;
                    $model->diagnostico = $texto->diagnos;
                    $model->observaciones = $texto->observ;
                    break;
                case 5: //IMQ
                    $model->material = $texto->material;
                    $model->tecnica = $texto->tecnica;
                    $model->macroscopia = $texto->macro;
                    $model->microscopia = $texto->micro;
                    $model->diagnostico = $texto->diagnos;
                    $model->observaciones = $texto->observ;
                    break;
                
            }
                
            
        }
        

		public function actionRefresh($id=null) {
			 $model = $this->findModel ( $id );
			 $dataproviderMultimedia = new ArrayDataProvider([
                            'allModels' => Multimedia::findAll(['Informe_id'=>$model->id]),
            ]);
			$gal =  $this->renderAjax('galeria_1', [
                                        'model' => $model,
                                        'dataproviderMultimedia' => $dataproviderMultimedia,
                                    ]);
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['rta'=>'ok', 'galeria'=>$gal];
            die();
		}
	/**
	 * Updates an existing Informe model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */

	public function actionUpdate($id=null) {	
	
		if(isset($id)){
				$model = $this->findModel ( $id );
		}else{
				$model=$this->findModel(Yii::$app->request->post('Informe_id'));
		}
		if ($model) {
        	$modelp = $model->protocolo;
        }

		if (isset($_POST['Protocolo']['observaciones'])){
			$modelp->observaciones = $_POST['Protocolo']['observaciones'];
			$modelp->save(false);
		}

		if (isset($_POST['Informe']['editorTags'])){
			$tagsPost=$_POST['Informe']['editorTags']; 
			$model->setEditorTags($tagsPost);
		}
		
        $nominf = new InformeNomenclador();
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
       

        $searchModel = new InformeNomencladorSearch();
        $informeNomenclador = new InformeNomenclador();
        $searchModel->id_informe = $model->id;
        $dataProvider = $searchModel->search([]);
        $informe=$this->findModel( $model->id );
        $historialPaciente=$informe->getHistorialUsuario();

        if (is_null($model->titulo)) {
            $model->titulo = $model->estudio->titulo;
        }
        // View to Render
        //Obtener fotos
        $dataproviderMultimedia = new ArrayDataProvider([
                            'allModels' => Multimedia::findAll(['Informe_id'=>$model->id]),
            ]);
  
		$codigo = "";
        if($model->WorkflowLastState!= Workflow::estadoEntregado()){
            if ($model->load ( Yii::$app->request->post () ) && $model->save () ) {
                if ($model->estudio->nombre === 'PAP') {
                        return $this->render ( 'update_pap', [ 
                                        'model' => $model,
                                        'modelp' => $modelp,
                                        'dataProvider' => $dataProvider ,
                                        'historialPaciente'=>$historialPaciente,
                                        'modeloInformeNomenclador' =>  $informeNomenclador,
										'dataproviderMultimedia'=>$dataproviderMultimedia,
										'codigo'=>$codigo,
                        ] );
                } else {
                        return $this->render ( 'update', [ 
                                        'model' => $model,
                                        'modelp' => $modelp,
                                        'dataProvider' => $dataProvider,
                                        'historialPaciente'=>$historialPaciente,
                                        'modeloInformeNomenclador' =>  $informeNomenclador,
                                        'dataproviderMultimedia'=>$dataproviderMultimedia,
                                        'codigo'=>$codigo,
                        ] );
                }
            }
            //obtine el utlimo estado 
			//var_dump($model->id);
            $ultimoEstado = Workflow::find ( 'id' )->where ( [
                            'Informe_id' => $model->id
                                ] )->orderBy ( [
                                                '(id)' => SORT_DESC
                                ] )->one ();
            //se asigna un estudio y lo cambia al estado en proceso       
		//	var_dump($ultimoEstado);  die();
            if($ultimoEstado->Estado_id===Workflow::estadoPendiente()){
                    $this->autoAsignarEstudio( $model->id, $ultimoEstado );
            }else{
                    $this->updateEstadoEnProceso( $model->id, $ultimoEstado );
            }
     
            //multimedia
            $file=Yii::$app->request->post('Informe_id');
            if(isset($file)){
                $this->multimediaUpload();
				$id=$model->id;
				$dataproviderMultimedia = new ArrayDataProvider([
					'allModels' => Multimedia::findAll(['Informe_id'=>$model->id])]);
					return true;
				return $this->renderAjax('galeria_1', [
					'model' => $model,
					'dataproviderMultimedia' => $dataproviderMultimedia,
				]);
			}
		}
		$codigo = "";
        if ($model->estudio->nombre === 'PAP') {
                //    $model->leucositos= 0;
               //     $model->hematies= 0;
					if (isset($_GET['idtexto'])) {
					//	die('lpm');die();
                        $textoModel = new \app\models\Textos();
                        $texto = $textoModel->find()->where(['=', 'id', $_GET['idtexto']])->one(); //findModel($_GET['idtexto']);
                        $this->cargarModelo($model, $texto);      
						$codigo = $texto->codigo;
                        $model->save();
                    }
                    return $this->render ( 'update_pap', [ 
                                            'model' => $model,
                                            'modelp' => $modelp,
                                            'dataProvider' => $dataProvider,
                                            'historialPaciente'=>$historialPaciente,
                                            'modeloInformeNomenclador' =>  $informeNomenclador,
											'dataproviderMultimedia'=>$dataproviderMultimedia,
											'codigo'=>$codigo,
                                         ] );            
            } else {
                    if (isset($_GET['idtexto'])) {
                        $textoModel = new \app\models\Textos();
                        $texto = $textoModel->find()->where(['=', 'id', $_GET['idtexto']])->one(); //findModel($_GET['idtexto']);
						
                        $this->cargarModelo($model, $texto);      
                        $codigo = $texto->codigo;
                        $model->save();
                    }
                    return $this->render ( 'update', [ 
                                    'model' => $model,
                                    'modelp' => $modelp,
                                    'dataProvider' => $dataProvider,
                                    'historialPaciente'=>$historialPaciente,
                                    'modeloInformeNomenclador' =>  $informeNomenclador,
                                    'dataproviderMultimedia'=>$dataproviderMultimedia,
                                    'codigo'=>$codigo,
                    ] );
            }

		
	}
	
        
    public function actionImprimir($id, $estudio) {
		 switch ($estudio){
                    case \app\models\Estudio::getEstudioPap(): //pap
                        $this->actionPrintpap($id,$web=null);
                        break;
                    case \app\models\Estudio::getEstudioBiopsia(): //biopsia
                        $this->actionPrintanatomo($id);
                        break;
                    case \app\models\Estudio::getEstudioMolecular(): //molecular
                        $this->actionPrintmole($id);
                        break;
                    case \app\models\Estudio::getEstudioCitologia(): //citologia
                        $this->actionPrintcito($id);
                        break;
                    case \app\models\Estudio::getEstudioInmuno(): //IMQ
                         $this->actionPrintinf($id);
                        break;
                }
	}
	
	/**
	 * Uploda image .
	 * 
	 *
	 * 
	 * @return mixed
	 */
	
	public function multimediaUpload(){
		$model = $this->findModel( $_POST['Informe_id']);
		// Load images
		$files = UploadedFile::getInstances($model,'files');
		$upload_ok = TRUE;
		$filesUploads = 0;
        $idInforme=$model->id;
                
        //secuencia identifica a cada foto que pertenece a un informe determinado
        $secuencia_id=Multimedia::find("secuencia_id")->where(['Informe_id'=>$idInforme])->orderBy('secuencia_id desc')->one();
        $secuencia=$secuencia_id['secuencia_id'];
        if(!isset($secuencia)){
        	$secuencia=1;
        }else{
            $secuencia++;
        }
                     
		foreach ($files as $file) {
                    
			$filesUploads ++;
			$multimedia = new Multimedia();
			$multimedia->Informe_id = $model->id;
			$multimedia->tipoMultimedia_id = 1; // Tipo Imagen
			$multimedia->secuencia_id= $secuencia;
			//pathname : opt/lampp/htdocs/labNet/cipatlab/basic/web/uploads/
            $pathname=$multimedia->getImageFilePath().$model->Protocolo_id."/".$model->id."/";
			//$pathFolder : uploads/138/
           $pathFolder=$multimedia->getUrlImageFolder().$model->Protocolo_id."/".$model->id."/";                
            /*si no existe, se crea una carpeta con el id del protocolo */
			if (!file_exists($pathname)) {
				BaseFileHelper::createDirectory ( $pathname, $mode = 0755, $recursive = true );
			}
                    
			$nameOfFile=explode(".", $file->name);
			$ext = end($nameOfFile);
			$name =$nameOfFile[0];
			$filename = "I_".$model->id."_$secuencia"."_".$name.".{$ext}";
                     //   $filename_thumbnail = "thumb_I_".$model->id."_$secuencia"."_".$name.".{$ext}";
			$multimedia->path =$pathname. $filename;
            	if ($file->saveAs($multimedia->path, true)){
                	$multimedia->webPath = $multimedia->getUrlImageFolder().$model->Protocolo_id."/".$model->id."/".$filename;
				$multimedia->save();
			}
			else{
				$upload_ok = FALSE;
			}
			$upload_ok = $upload_ok && TRUE;
                    $secuencia++;
		}
	
        }

	
	/**
	 * cuando se abre un estudio en estado pendiente se autoasigna el mismo y se setea en estado "En proceso"
	 */
	public function autoAsignarEstudio($id,$ultimoEstado) {
		if (! is_null ( $ultimoEstado )) {
			
			/**
			 * actualiza el workflow que contiene el estado pendiente
			 */
			$fecha = date_create ();
			$fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
			$ultimoEstado->fecha_fin = $fecha;
			$ultimoEstado->update ();
			/**
			 * crea un nuevo workflow con estado en proceso
			 * 
			 * @var \app\models\Workflow $workf
			 */
			$workf = new Workflow ();
			$workf->Estado_id = Workflow::estadoEnProceso(); 
			$workf->Informe_id = $id;
			$workf->Responsable_id = \Yii::$app->user->getId ();
			$workf->fecha_inicio = $fecha;
			$workf->save ();
		}
	}
	
	/**
	 * cuando se abre un estudio en estado pausado  se setea en estado "En proceso" pero no se autoasigna
	 */
	public function updateEstadoEnProceso($id,$ultimoEstado) {
		if (! is_null ( $ultimoEstado )) {
				
			/**
			 * actualiza el workflow que contiene el estado en proceso
			 */
			$fecha = date_create ();
			$fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
			$ultimoEstado->fecha_fin = $fecha;
			$ultimoEstado->update ();
				
			// var_dump($ultimoEstado); die();
			/**
			* crea un nuevo workflow con estado en proceso
			*
			* @var \app\models\Workflow $workf
			*/
			$workf = new Workflow ();
			$workf->Estado_id = Workflow::estadoEnProceso();
			$workf->Informe_id = $id;
			$workf->Responsable_id =$ultimoEstado->Responsable_id;
			$workf->fecha_inicio = $fecha;
			$workf->save ();
		}
	}
	
	public function actionFinalizarcarga() {
		if (isset ( Yii::$app->request->post () ['Informe'] ['id'] )) {
			$model = $this->findModel ( Yii::$app->request->post () ['Informe'] ['id'] );
			if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
				return $this->redirect ( [ 
						'//protocolo/index' 
				] );
			}
		}
	}
        
   public function actionEntregar($accion,$estudio=null,$id) {
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}else{
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return ['rta'=>'error', 'message'=>'Fallo'];die();
		}
		

			//obtine el utlimo estado 
			$idUltimoWorkflow=$model->getWorkflowLastStateId();
			$ultimoEstado=null;
			$ultimoEstado = Workflow::find ( 'id' )->where ( [
							'id' => $idUltimoWorkflow
								] )->one();
		
			if (! is_null ( $ultimoEstado ) ) {

				$estado_entregado= Workflow::estadoEntregado(); 	
				if($ultimoEstado->Estado_id==$estado_entregado){
					$estado_actual=$estado_entregado;
				}else{
					$estado_actual=5;
				}
				/**
				* actualiza el workflow que contiene el estado pendiente
				*/
				$fecha = date_create ();
				$fecha = date_format ( $fecha, 'd-m-Y H:i:s' );
				$ultimoEstado->fecha_fin = $fecha;
				$ultimoEstado->update ();
				/**
				* crea un nuevo workflow con estado Entregado
				* 
				* @var \app\models\Workflow $workf
				*/
				$workf = new Workflow ();
				$workf->Estado_id = $estado_entregado; 
				$workf->Informe_id = $id;
				$workf->Responsable_id = \Yii::$app->user->getId ();
				$workf->fecha_inicio = $fecha;
				$workf->fecha_fin = $fecha;
				$workf->save ();  
			}
				
			if($accion==="print" && isset($estudio)){
				switch ($estudio){
					case \app\models\Estudio::getEstudioPap(): //pap
						$this->actionPrintpap($id,$web=null);
						break;
					case \app\models\Estudio::getEstudioBiopsia(): //biopsia
						$this->actionPrintanatomo($id);
						break;
					case \app\models\Estudio::getEstudioMolecular(): //molecular
						$this->actionPrintmole($id);
						break;
					case \app\models\Estudio::getEstudioCitologia(): //citologia
						$this->actionPrintcito($id);
						break;
					case \app\models\Estudio::getEstudioInmuno(): //IMQ
						$this->actionPrintinf($id);
						break;
				}
			}else if($accion==="publicar"){
				if($estado_actual==5){
					return $this->redirect ( [ 
								'//protocolo/terminados' 
						] );
				}else{
					return $this->redirect ( [ 
								'//protocolo/entregados' 
						] );
				}
					
			}else{//mail
					if(!empty($modelp->pacienteMail)){	
						if ($this->actionMailing($model)){
					
							if($estado_actual==5){//finalizado
								return $this->redirect ( [ 
											'//protocolo/terminados' 
									] );
							}else{
								return $this->redirect ( [ 
											'//protocolo/entregados' 
									] );
							}
						}	
					}else{
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return ['rta'=>'error', 'message'=>'Error, el paciente no tiene mail.'];die();
					}  	
				}
		}   
	
      
	   
	public function papreducido($id) {
        //Datos generales del Laboratorio
        $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
                
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
                $vista = 'print_pap_reducido';
                $header ='Sistema LABnet';   
               
                
		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
                                'cssFile' => '@app/web/css/print/print.css',
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( $vista, [ 
						'model' => $model,
						'modelp' => $modelp,
                        'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe PAP' 
				],
				'methods' => [ 
						'SetHeader' => [ 
								$header 
						],
				] 
		] );                
		return $pdf;
	}
	
	public function actionMailing($model=null,$estudio=null){
		$laboratorio = Laboratorio::find()->where(['id' => 1])->one();
		
		if ($model) {
			$modelp = $model->protocolo;
			if ( $modelp) {
			
					$estudio = $model->Estudio_id; 
					switch ($estudio){
						case \app\models\Estudio::getEstudioPap(): //pap
							$vista = '_print_pap_mail';
							break;
						case \app\models\Estudio::getEstudioBiopsia(): //biopsia
							$vista = '_print_biopsia_mail';
							break;
						case \app\models\Estudio::getEstudioMolecular(): //molecular
							$vista = '_print_mole_mail';
							break;
						case \app\models\Estudio::getEstudioCitologia(): //citologia
							$vista = '_print_inf_cito_mail';
							break;
						case \app\models\Estudio::getEstudioInmuno(): //IMQ
							$vista = '_print_inf_mail';
							break;
					}



							
					$mpdf=new Pdf();
					$pdf1 = new Pdf ( [
							// 'mode' => Pdf::MODE_CORE,
							'mode' => Pdf::MODE_BLANK,
							// A4 paper format
							'format' => Pdf::FORMAT_A4,
							// portrait orientation
							'orientation' => Pdf::ORIENT_PORTRAIT,
							// stream to browser inline
							'destination' => Pdf::DEST_DOWNLOAD,                
							'cssFile' => '@app/web/css/print/informe.css',
							'cssInline' => '* {font-size:14px;}',
							// set mPDF properties on the fly
							'content' => $this->renderPartial ( $vista, [ 
									'model' => $model,
									'modelp' => $modelp,
									'laboratorio' => $laboratorio,
							] ),
					] );            
					$titulo = $model->id.'-'.$model->titulo."-".date('Y-m-d-H-i-s');
					$mpdf = $pdf1->api;
					$mpdf->WriteHTML($pdf1->content); //pdf is a name of view file responsible for this pdf document
					$path = $mpdf->Output(Yii::getAlias('@app/runtime/mpdf/').$titulo.'.pdf', 'F');

					$ee =   Yii::$app->mailer->compose()
						->setFrom('alejandra@qwavee.com')
						->setTo($modelp->pacienteMail)
						->setTextBody($laboratorio->nombre)
						->setSubject('Envío de Resultados de Laboratorio CIPAT')
						->setHtmlBody($laboratorio->nombre.'<b> le envía los resultados del análisis</b>')
						->attach(Yii::getAlias('@app/runtime/mpdf/').$titulo.'.pdf');
					if ($ee->send()) 
						return 1;
					else
						return 0;
			}		
		}
		return false;
  }
        
        
		public function actionPrintreducido($id,$estudio){
             switch ($estudio){
                    case \app\models\Estudio::getEstudioPap(): //pap
                        $this->actionPrintpapreducido($id,$web=null);
                        break;
                    case \app\models\Estudio::getEstudioBiopsia(): //biopsia
                        $this->actionPrintanatomoreducido($id);
                        break;
                    case \app\models\Estudio::getEstudioMolecular(): //molecular
                        $this->actionPrintmolereducido($id);
                        break;
                    case \app\models\Estudio::getEstudioCitologia(): //citologia
                        $this->actionPrintacitoreducido($id);
                        break;
                    case \app\models\Estudio::getEstudioInmuno(): //IMQ
                         $this->actionPrintinfreducido($id);
                        break;
                }
		}
        
        
        public function actionPrintpapreducido($id) {
                //Datos generales del Laboratorio
                $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
                
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
                $vista = 'print_pap_reducido';
                $header ='Sistema LABnet';   
               
                
		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
                                'cssFile' => '@app/web/css/print/print.css',
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( $vista, [ 
						'model' => $model,
						'modelp' => $modelp,
                                                'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe PAP' 
				],
				'methods' => [ 
						'SetHeader' => [ 
								$header 
						],
				] 
		] );                
		return $pdf->render ();
	}
        
        
        //este
        public function actionPrintmolereducido($id) {
                //Datos generales del Laboratorio
                $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
                
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
        
                $vista = 'print_mole_reducido';
                $header ='Sistema LABnet';                    


		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
				'cssFile' => '@app/web/css/print/print.css',
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( $vista, [ 
						'model' => $model,
						'modelp' => $modelp,
                                                'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe PAP' 
				],
				'methods' => [ 
						'SetHeader' => [ 
								$header 
						],
				] 
		] );                
		return $pdf->render ();
	}
        
        
        
        public function actionPrintanatomoreducido($id) {
                $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
                
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
                $vista = 'print_anatomo_reducido';
                $header ='Sistema LABnet';                    


		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
				'cssFile' => '@app/web/css/print/print.css',    
				// any css to be embedded if required
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( $vista, [ 
						'model' => $model,
						'modelp' => $modelp,
                                                'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe PAP' 
				],
				'methods' => [ 
						'SetHeader' => [ 
								$header 
						],
				] 
		] );                
		return $pdf->render ();
	}
        
        
    public function actionPrintacitoreducido($id) {
                //Datos generales del Laboratorio
                $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
                
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
                $vista = 'print_cito_reducido';
                $header ='Sistema LABnet';                    


		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
				'cssFile' => '@app/web/css/print/print.css',
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( $vista, [ 
						'model' => $model,
						'modelp' => $modelp,
                        'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe PAP' 
				],
				'methods' => [ 
						'SetHeader' => [ 
								$header 
						],
				] 
		] );                            
		return $pdf->render ();
	}
        
        
    public function actionPrintinfreducido($id) {
                //Datos generales del Laboratorio
                $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
                
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
                $vista = 'print_inf_reducido';
                $header ='Sistema LABnet';                    


		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
				'cssFile' => '@app/web/css/print/print.css',
				// any css to be embedded if required
				'cssInline' => '* {font-size:9px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( $vista, [ 
						'model' => $model,
						'modelp' => $modelp,
                                                'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe PAP' 
				],
				'methods' => [ 
						'SetHeader' => [ 
								$header 
						],
				] 
		] );                
		return $pdf->render ();
	}
        
        
 
        
	public function actionPrintpap($id,$web=null) {
        //Datos generales del Laboratorio
        $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
                
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
                $vista = '_print_pap';
                $header = '';
                if (isset($web)){
                    $vista = '_web_pap';
                    $header ='Sistema LABnet';                    
                }
                
		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
				'cssFile' => '@app/web/css/print/informe.css',
				// any css to be embedded if required
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( $vista, [ 
						'model' => $model,
						'modelp' => $modelp,
                                                'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe PAP' 
				],
				'methods' => [ 
					//	'SetHeader' => [ 
					//			$header 
					//	],
						'SetFooter' => [ 
								$laboratorio->direccion.'|web: '.$laboratorio->web.'|Tel.:'.$laboratorio->telefono 
						] 
				] 
		] );                
		return $pdf->render ();
	}
	public function actionPrintinf($id) {
        //Datos generales del Laboratorio
        $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
		
		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
				'cssFile' => '@app/web/css/print/informe.css',
				// any css to be embedded if required
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( '_print_inf', [ 
						'model' => $model,
						'modelp' => $modelp,
                                                'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Informe Inmunohistoquímico' 
				],
				'methods' => [ 
						'SetHeader' => [ 
								'Sistema LABnet' 
						],
						'SetFooter' => [ 
								$laboratorio->direccion.'|web: '.$laboratorio->web.'|Tel.:'.$laboratorio->telefono 
						] 
				] 
		] );
		
		return $pdf->render ();
	}
	public function actionPrintanatomo($id) {
                //Datos generales del Laboratorio
                $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
		
		$pdf = new Pdf ( [
                    // 'mode' => Pdf::MODE_CORE,
                    'mode' => Pdf::MODE_BLANK,
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4,
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    // stream to browser inline
                    'destination' => Pdf::DEST_BROWSER,
                    'cssFile' => '@app/web/css/print/informe.css',
                    // any css to be embedded if required
                    'cssInline' => '* {font-size:14px;}',
                    // set mPDF properties on the fly

                    'content' => $this->renderPartial ( '_print_biopsia', [ 
                                    'model' => $model,
                                    'modelp' => $modelp,
                                    'laboratorio' => $laboratorio,
                    ] ),
                    'options' => [ 
                                    'title' => 'Informe Anatomopatológico' 
                    ],
                    'methods' => [ 
                               //     'SetHeader' => [ 
                               //                     'Sistema LABnet' 
                              //      ],
                                    'SetFooter' => [ 
                                                    $laboratorio->direccion.'|web: '.$laboratorio->web.'|Tel.:'.$laboratorio->telefono 
                                    ] 
                    ] 
		] );
		
		return $pdf->render ();
	}
        
        public function actionPrintmole($id) {
            //Datos generales del Laboratorio
			$laboratorio = Laboratorio::find()->where(['id' => 1])->one();
			$model = $this->findModel ( $id );
			if ($model) {
				$modelp = $model->protocolo;
			}
		
			$pdf = new Pdf ( [
                    // 'mode' => Pdf::MODE_CORE,
                    'mode' => Pdf::MODE_BLANK,
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4,
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    // stream to browser inline
                    'destination' => Pdf::DEST_BROWSER,
                    'cssFile' => '@app/web/css/print/informe.css',
                    // any css to be embedded if required
                    'cssInline' => '* {font-size:14px;}',
                    // set mPDF properties on the fly

                    'content' => $this->renderPartial ( '_print_mole', [ 
                                    'model' => $model,
                                    'modelp' => $modelp,
                                    'laboratorio' => $laboratorio,
                    ] ),
                    'options' => [ 
                                    'title' => 'BIOLOGIA MOLECULAR - HPV DNA TEST' 
                    ],
                    'methods' => [ 
                                 //   'SetHeader' => [ 
                                //                    'Sistema LABnet' 
                                //    ],
                                    'SetFooter' => [ 
                                                    $laboratorio->direccion.'|web: '.$laboratorio->web.'|Tel.:'.$laboratorio->telefono 
                                    ] 
                    ] 
			] );
		
		return $pdf->render ();
	}
        
      
	public function actionPrintcito($id) {
                //Datos generales del Laboratorio
                $laboratorio = Laboratorio::find()->where(['id' => 1])->one();
		$model = $this->findModel ( $id );
		if ($model) {
			$modelp = $model->protocolo;
		}
		
		$pdf = new Pdf ( [
				// 'mode' => Pdf::MODE_CORE,
				'mode' => Pdf::MODE_BLANK,
				// A4 paper format
				'format' => Pdf::FORMAT_A4,
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT,
				// stream to browser inline
				'destination' => Pdf::DEST_BROWSER,
				'cssFile' => '@app/web/css/print/informe.css',
				// any css to be embedded if required
				'cssInline' => '* {font-size:14px;}',
				// set mPDF properties on the fly
				
				'content' => $this->renderPartial ( '_print_inf_cito', [ 
						'model' => $model,
						'modelp' => $modelp,
                                                'laboratorio' => $laboratorio,
				] ),
				'options' => [ 
						'title' => 'Estudio de Citología Especial' 
				],
				'methods' => [ 
				//		'SetHeader' => [ 
				//				'Sistema LABnet' 
				//		],
						'SetFooter' => [ 
								$laboratorio->direccion.'|web: '.$laboratorio->web.'|Tel.:'.$laboratorio->telefono 
						] 
				] 
		] );
		
		return $pdf->render ();
	}
	
 
     /**
     * Deletes an existing informe model.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return;// $this->redirect(['index']);
    }

  
    
    protected function findModel($id)
    {
        if (($model = Informe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

        
    public function actionAddnomenclador() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $model = new InformeNomenclador();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['rta'=>'ok', 'message'=>''];
            die();
        } else {
            return ['rta'=>'no ok', 'message'=>''];die();
        }

        $model = $this->findModel ( $id );
        $modelp = $model->protocolo;
        $searchModel = new InformeNomencladorSearch();
             $searchModel->id_informe = $id;
             $dataProvider = $searchModel->search([]);
             $informe=$this->findModel( $id );
             $historialPaciente=$informe->getHistorialUsuario();
             return $this->render ( 'update', [ 
                                             'model' => $model,
                                             'modelp' => $modelp,
                                             'dataProvider' => $dataProvider,
                                             'historialPaciente'=>$historialPaciente
                             ] );

        return $this->renderAjax ( '//protocolo/_nomencladores', [ 
                                    'model' => $model,
                                    'modelp' => $model,
            'informe' => $model,
            'dataProvider' => null

                    ] );
        return $this->render ( [ 
                            'update' 
            ] );       

            return $this->renderAjax ( '_addNomenclador', [ 
                                    'model' => $model 
                    ] );
    }
	

	
	
}
