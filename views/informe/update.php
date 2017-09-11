<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Informe */
use app\models\Protocolo;
use yii\helpers\ArrayHelper;
use app\models\Estado;
use app\models\Estudio;
//use yii\bootstrap\Dropdown;
use app\models\User;
use app\models\Workflow;
use yii\widgets\Pjax;
use yii\helpers\Url;

use app\models\Nomenclador;
use kartik\editable\Editable;
use kartik\popover\PopoverX;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

use mdm\admin\components\Helper;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
BootboxAsset::register($this);

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Informe',
]) . $model->id;
$this->title = 'Protocolo N°: '. $modelp->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title , 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

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
                    'model' => $model, 
                   // 'informe'=>$informe, 
                     'dataProvider'=> $dataProvider, 'modeloInformeNomenclador' => $modeloInformeNomenclador]) 
                ?>
            </div>


    </div>

            <div  class="box">  
		             <div class="box-header with-border">
                        <h3 class="box-title">Historial Paciente</h3>
                    </div>
		             
		  	        <div  id="historialPacientePanel" data-spy="scroll" data-offset="3" data-target="#historial" class="panel-body text-center" style=" position: relative;">	                                                         
	                        <?php 
		                            if(is_array($historialPaciente)){
		                                echo	$this->render('/informe/historialPaciente', [
		                                    'historialPaciente'=>$historialPaciente
		                                ]) ;
		                            }else{
		                                    echo "El Paciente no tiene historial.";
		                            }
                                          
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
                                    <button type="button" class="btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class=" estadoDesc">                                    
                                            <i class="fa fa-chevron-down"></i>                             
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
                                    <button type="button" class="btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class="rounded estadoDesc">                                    
                                            <i class="fa fa-chevron-down"></i>                           
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
                            <button class="btn btn-default btn-sm  mostrarTree pull-right" title="Agregar texto"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-default btn-sm  guardarTexto pull-right" value="<?= Url::to(['textos/copy']) ?>"><i class="fa fa-copy"></i></button>
                            <?php  
                                    echo  Html::button("<i class='fa fa-list-alt'></i>",
                                        ['class'=>'btn btn-default btn-sm pull-right',
                                            'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/informe/printreducido','id'=>$model->id, 'estudio' => $model->Estudio_id ]) . "';",
                                            'data-toggle'=>'tooltip',
                                            'title'=>Yii::t('app', 'Informe Reducido'),
                                        ]
                                    );
                            ?>
                            <?php   $url = ['informe/print', 'id' => $model->id , 'estudio' => $model->Estudio_id];
                                    echo  Html::button("<i class='fa fa-file-pdf-o'></i>",
                                        ['class'=>'btn btn-default btn-sm  pull-right',
                                            'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/informe/imprimir','id'=>$model->id, 'estudio' => $model->Estudio_id ]) . "';",
                                            'data-toggle'=>'tooltip',
                                            'title'=>Yii::t('app', 'Informe Preliminar'),
                                        ]
                                    );
                            ?>
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
            <div class="box-body no-padding">
                  <?= $this->render('_form', [
                    'model' => $model, 
                    'modelp' => $modelp, 
                    'edad'=>$modelp->pacienteEdad,
                    'dataproviderMultimedia'=>$dataproviderMultimedia,
                    'codigo'=>$codigo,
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php

$this->registerJsFile('@web/assets/admin/js/cipat_modal_informe.js', ['depends' => [yii\web\AssetBundle::className()]]);


    Modal::begin([
                    'id' => 'modal',    
                   // 'size'=>'modal-lg',
                    'options' => ['tabindex' => false ],
                ]);
                echo "<div id='modalContentAutotexto' ></div>";      
    Modal::end();
    

?>


            
