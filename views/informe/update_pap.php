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
use app\models\Nomenclador;
use kartik\popover\PopoverX;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use xj\bootbox\BootboxAsset;


$this->title = Yii::t('app', 'Update {modelClass}: ', [
		'modelClass' => 'Informe',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
//         $this->registerJs("
//             $('#historialPacientePanel').scrollspy({ target: '#historial' })");
  ?>  

<div class="row">
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Protocolo N°: <b><?= $modelp->codigo ?></h3>
            </div>
            <div class="box-body no-padding">
                <?= $this->render('//protocolo/view_informe', [
                    'model' => $modelp, 'informe'=>$model, 'dataProvider'=> $dataProvider, 'modeloInformeNomenclador' => $modeloInformeNomenclador
                ]) ?>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Nomencladores</h3>
                <div class="pull-right">
                    <div class="btn-group"> 
                       
                        <?php 
                            $data =  Nomenclador::find()->asArray()->all();
                            $data2 =  ArrayHelper::map($data, 'id', 'servicio');
                            
                            //$model->id = null;
                            $modelIN = $modeloInformeNomenclador;
                            $url = Url::to(['/informe-nomenclador/create']);
                            PopoverX::begin([
                                'placement' => PopoverX::ALIGN_TOP,
                                'id'=> 'popNomenclador',
                                'toggleButton' => ['label'=>'', 'class'=>' fa fa-plus'],
                                'header' => '<!--i class="glyphicon glyphicon-lock"></i-->Agregar nomenclador',
                                'footer'=> Html::a('<span class="btn btn-info click"> Agregar</span>', $url)//Html::Button('Agregar', ['class'=>'btn btn-sm btn-primary click'])// .
                                        // Html::resetButton('Cancelar', ['class'=>'btn btn-sm btn-default'])
                            ]);
                           // echo $form->field($model, 'id_nomenclador')->textInput(['placeholder'=>'Nomenclador...']);
                            $form = ActiveForm::begin([
                                    'id' => 'addNom',
                                    'fieldConfig'=>['showLabels'=>false],                                   
                                     'action' => Url::to(['/informe-nomenclador/create']),
                                    ]);
                            
                            echo $form->field($modelIN, 'id_nomenclador',[
                                'template' => "{label}
                                            <div id='SelecNomenclador'>{input}</div>
                                            {hint}
                                            {error}"])->widget(Select2::classname(), [
                                    'data'=>$data2,'language'=>'es',
                                    'toggleAllSettings' => [                                    
                                    'selectOptions' => ['class' => 'text-success'],
                                    'unselectOptions' => ['class' => 'text-danger'],
                                     ],
                                    'options' => ['multiple' => false]
                            ]);
                            echo $form->field($modelIN, 'cantidad')->textInput(['placeholder'=>'Cantidad...']);
                            echo $form->field($modelIN, 'id_informe')->hiddenInput( array('value'=>$model->id))->label(false);
                            ActiveForm::end(); 
                            PopoverX::end();
                            
                        ?>
                    </div>
                </div>
            </div>
            <div class="box-body no-padding">             
                <?php
                    echo $this->render('//protocolo/_nomencladores_informe', [
                    'model' => $model, 'informe'=>$informe,  'dataProvider'=> $dataProvider, 'modeloInformeNomenclador' => $modeloInformeNomenclador]) 
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box">
            <div class="box-header with-border">
                <div id="row">
                    <div class="col-md-3">
                        <h3 class="box-title"><?php echo 'Estudio: '.$model->estudio->descripcion; ?></h3>
                    </div>
                     <div class="col-md-3">                       
                            <?php Pjax::begin(['id'=>'estado']); ?>                                 
                                   <?php echo "Estado: ". $model->workflowLastStateName; ?>
                                   <?php if(Helper::checkRoute('/workflow/*')){?>
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class="rounded estadoDesc">                                    
                                            Estado                                
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
                            <?php Pjax::end(); ?> 
                        </div>
                        <div class="col-md-3">
                            <?php Pjax::begin(['id'=>'estado']); ?>                                 
                                   <?php echo "Asignado: ". $model->workflowLastAsignationUser; ?>
                                   <?php if(Helper::checkRoute('/workflow/*')){?>
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class="rounded estadoDesc">                                    
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
                            <?php Pjax::end(); ?>   
                        </div> 
                    
                     <div class="col-md-3">
                         <button type="button" class="btn btn-primary btn-sm text pull-right" data-toggle="tooltip" title="" data-original-title="Date range">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                        <button class="btn btn-primary btn-sm mostrarTree pull-right" title="Agregar texto"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-primary btn-sm guardarTexto pull-right" value="<?= Url::to(['textos/copy']) ?>"><i class="fa fa-copy"></i></button>
                        <?php $url = ['informe/printpapreducido', 'id' => $model->id , 'estudio' => $model->Estudio_id];
                              echo  Html::button("<i class='fa fa-list-alt'></i>",
                                    ['class'=>'btn btn-primary btn-sm pull-right',
                                        'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/informe/printpapreducido','id'=>$model->id, 'estudio' => $model->Estudio_id ]) . "';",
                                        'data-toggle'=>'tooltip',
                                        'title'=>Yii::t('app', 'Informe Reducido'),
                                    ]
                                );
                        ?>

                        <?php   $url = ['informe/print', 'id' => $model->id , 'estudio' => $model->Estudio_id];
                                echo  Html::button("<i class='fa fa-file-pdf-o'></i>",
                                    ['class'=>'btn btn-primary btn-sm pull-right',
                                        'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/informe/printpap','id'=>$model->id, 'estudio' => $model->Estudio_id ]) . "';",
                                        'data-toggle'=>'tooltip',
                                        'title'=>Yii::t('app', 'Informe Preliminar'),
                                    ]
                                );
                                $url = ['informe/printreducido', 'id' => $model->id , 'estudio' => $model->Estudio_id];
                         ?>
                                <!--input type="text"value="<?php echo  $model->id ?>" id="id_informe" style="display:none">
                                <input type="text"value="<?php echo $model->Estudio_id ?>" id="id_estudio" style="display:none"-->
                    </div>
                </div>    
                    
                <!--div class="pull-right box-tools"> 
                   
                        <label>Asignado: 
                        <!--select name="example1_length" aria-controls="example1" class="form-control input-sm">
                            <option value="10">10</option><option value="25">25</option><option value="50">50</option>
                            option value="100">100</option>
                            </select--> 
                        </label> 
                <!-- botones derecha_-->
            </div>
            <div class="box-body">
                  <?= $this->render('_form_pap', [
                    'model' => $model, 
                    'edad'=>$modelp->pacienteEdad,
                    'dataproviderMultimedia'=>$dataproviderMultimedia,
                    'codigo'=>$codigo,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<!--section id="page-content">
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
		        </div><!-- /.panel-heading ->
		             
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
        <!-- Start body content ->            
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
                                <li><a href="#" class="btn-delete">Delete</a></li>->
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
                </div><!-- /.panel-heading ->   
                                


        <?php /*echo $this->render('_form_pap', [
            'model' => $model, 
        	'edad'=>$modelp->pacienteEdad,
        	'dataproviderMultimedia'=>$dataproviderMultimedia,
        ]);*/
        ?>



            </div>
        </div>
            
            </div>
        </div>
    </div>
        
</section-->
            
