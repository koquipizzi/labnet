<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Informe */
use app\models\Protocolo;
use yii\helpers\ArrayHelper;
use app\models\Estado;
use app\models\User;
use app\models\Estudio;
use app\models\Workflow;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use mdm\admin\components\Helper;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
		'modelClass' => 'Informe',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
//         $this->registerJs("
//             $('#historialPacientePanel').scrollspy({ target: '#historial' })");
  ?>  
<section id="page-content">
    <div class="body-content animated fadeIn">
    <div class="row">
    	<div class="col-md-3">
              <?php
                   echo $this->render('//protocolo/view_informe', [
                                        'model' => $modelp, 'informe'=>$model, 
                                        'dataProvider'=> $dataProvider,
                                        'modeloInformeNomenclador' => $modeloInformeNomenclador
                                    		
                    ]) 
               ?>
		  <div  class="panel">  
		         <div class="panel-heading">
		              <div class="panel-title text-left">Historial Paciente</div>
		        </div><!-- /.panel-heading -->
		             
		  	    <div  id="historialPacientePanel" data-spy="scroll" data-offset="3" data-target="#historial" class="panel-body text-center" style=" position: relative;">
	                            
                                <div style="text-align: left; margin-top:10px;">

	                                <div class="recent-activity">                                
	                                   <?php 
		                         /*           if(is_array($historialPaciente)){
		                                    echo	$this->render('/informe/historialPaciente', [
		                                    		'historialPaciente'=>$historialPaciente
		                                    	]) ;
		                                    }else{
		                                    		echo "El Paciente no tiene historial.";
		                                  		  }
                                          * 
                                          */
	                                    ?>
	
                                        </div>
                                </div>
                                    
                            </div>
                            
      		</div>
         </div>
        

        
        <div class="col-md-9">           
        <?php if($model->estado_actual===Workflow::estadoEntregado()){
            echo '<div class="panel rounded shadow"> <h3>Este estudio no puede modificarse porque ya se encuentra entregado</h3></div>';
        } ?>  
        <!-- Start body content -->            
        <div class="panel rounded shadow">                           
            <div class="informe-update">
                
                <div class="panel-labnet">
                  <div class="row">     
                    <div class="col-md-4">  
                        <div class="pull-left">
                            <h3 class="panel-title"><?php echo 'Estudio: '.$model->estudio->descripcion; ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3">                       
                                   <?php Pjax::begin(['id'=>'estado']); ?>
                                        <h5 id="H5ultimoEstado">
                                            <?php echo "Estado: ". $model->workflowLastStateName; ?>

                                        </h5>                                   
                                    <?php Pjax::end(); ?> 
                           <?php if(Helper::checkRoute('/workflow/*')){?>
                        <button type="button" class="btn btn-infor dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="label label-success rounded estadoDesc">                                    
                                            Cambiar Estado                          
                                </span>
                           
                        </button>
                           <?php }?>
                            <ul class="dropdown-menu pull-right">
                                    <?php 
                                    	
                                        $dataEstado=Estado::find()->where("autoAsignado != 'S'")->asArray()->all();    
                                       // var_dump($dataEstado);die();
                                        foreach ($dataEstado as $estado) //var_dump($estado['descripcion']);die();
                                            echo "<li><a href='#".$estado['id']."' class='btn-view change-estado'  data-workflow='".$model->currentWorkflow."' data-informe='".$model->id."' data-estado='".$estado['id']."' data-estadotexto='".$estado['id']."' >".$estado['descripcion']."</a></li>";
                                           
                                    ?>
<!--                                    <li><a href="#" class="btn-view">View</a></li><li><a href="#" class="btn-edit">Edit</a></li><li role="separator" class="divider"></li>
                                <li><a href="#" class="btn-delete">Delete</a></li>-->
                            </ul>
                           
                    </div>
                    <div class="col-md-3">  
			<div class="pull-right">				

                        <div class="btn-group">                        
                            <?php Pjax::begin(['id'=>'estado']); ?>
                                 <h5>
                                   <?php echo "Asignado: ". $model->workflowLastAsignationUser; ?>   
                                 </h5>                                   
                            <?php Pjax::end(); ?>  
                            <?php if(Helper::checkRoute('/workflow/*')){?>
                                <button type="button" class="btn btn-infor dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="label label-success rounded estadoDesc">                                    
                                       Asignar a                                
                                    </span>
                                </button>
                            <?php }?>  
                                <ul class="dropdown-menu pull-right">
                                    <?php 
                                        $dataUsuarios=User::find()->asArray()->all();    
                                        foreach ($dataUsuarios as $usuario) 
                                            echo "<li><a href='#".$usuario['id']."' class='btn-view change-estado' ' data-usuario='".$usuario['id']."' data-estadotexto='".$usuario['id']."' data-informe='".$model->id."' >".$usuario['username']."</a></li>";
                                    ?>
                            </ul>
                        </div>                         
                    </div>
                </div>
                    <div class="col-md-2">
                        <div class="" style="margin-top: 10px;">
                            
                                <button class="btn btn-circle btn-teal mostrarTree" title="Agregar texto"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-circle btn-teal guardarTexto" value="<?= Url::to(['textos/copy']) ?>"><i class="fa fa-copy"></i></button>
                                <?php $url = ['informe/printreducido', 'id' => $model->id , 'estudio' => $model->Estudio_id];
                                  echo    Html::a( "R ", $url, ["class"=>"btn btn-circle btn-teal"] ); ?>
                                <input type="text"value="<?php echo  $model->id ?>" id="id_informe" style="display:none">
                                <input type="text"value="<?php echo $model->Estudio_id ?>" id="id_estudio" style="display:none">
                                
                        </div>
                    </div>
                      
             </div>
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->   
                                


        <?= $this->render('_form_pap', [
            'model' => $model, 
        	'edad'=>$modelp->pacienteEdad,
        	'dataproviderMultimedia'=>$dataproviderMultimedia,
        ]);
        ?>



            </div>
        </div>
            
            </div>
        </div>
    </div>
        
</section>
            

<?php

       
use app\assets\admin\dashboard\DashboardAsset;
DashboardAsset::register($this);
$this->registerJsFile('@web/assets/admin/js/cipat_modal_informe.js', ['depends' => [yii\web\AssetBundle::className()]]);


    Modal::begin([
                    'id' => 'modal',    
                   // 'size'=>'modal-lg',
                    'options' => ['tabindex' => false ],
                ]);
                echo "<div id='modalContent'></div>";      
    Modal::end();
    

?>
