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
use yii\bootstrap\Modal;
use app\models\Nomenclador;
use kartik\editable\Editable;
use kartik\popover\PopoverX;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

use mdm\admin\components\Helper;
use xj\bootbox\BootboxAsset;

BootboxAsset::register($this);

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Informe',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
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
            <div class="box-body no-padding">             
                <?php
                    echo $this->render('//protocolo/_nomencladores', [
                    'model' => $model, 'informe'=>$informe,  'dataProvider'=> $dataProvider, 'modeloInformeNomenclador' => $modeloInformeNomenclador]) 
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Monthly Recap Report</h3>
            </div>
            <div class="box-body">
                <h3 class="box-title">Monthly Recap Report</h3>
            </div>
        </div>
    </div>
</div>

<section id="page-content">
    <div class="body-content animated fadeIn">
    <div class="row">
      <div class="col-md-3">
           
          <?= $this->render('//protocolo/view_informe', [
               'model' => $modelp, 'informe'=>$model, 'dataProvider'=> $dataProvider, 'modeloInformeNomenclador' => $modeloInformeNomenclador
          ]) ?>
         <div class="panel">  
                <div class="panel-heading">
                    <h3 class="panel-title text-left">Historial Paciente</h3>
                </div><!-- /.panel-heading -->
   
                    <div  id="historialPacientePanel" data-offset="3" data-target="#historial" class="panel-body text-center" style=" position: relative;">

                        <div class="recent-activity">                                

                            <?php 
                                  /*  if(is_array($historialPaciente)){
                                        echo $this->render('/informe/historialPaciente', [
                                                'historialPaciente'=>$historialPaciente
                                        ]) ;
                                    }else{
                                                echo "El Paciente no tiene historial.";
                                                  }*/
                            ?>
                        </div>
                    </div>

           </div>
                          
        </div>
    
        <div class="col-md-9">           
        <?php if($model->estado_actual===Workflow::estadoEntregado()){
            echo '<div class="panel rounded shadow"> <h3> Este estudio no puede modificarse porque ya se encuentra entregado </h3></div>';
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
                            <h5>
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
                                    foreach ($dataEstado as $estado) 
                                        echo "<li><a href='#".$estado['id']."' class='btn-view change-estado'  data-workflow='".$model->currentWorkflow."' data-informe='".$model->id."' data-estado='".$estado['id']."' data-estadotexto='".$estado['id']."' >".$estado['descripcion']."</a></li>";

                                ?>
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
                                <!--<button class="btn btn-circle btn-teal" id="informeReducido" value=""><i class="fa "></i></button>-->
                                  <?php $url = ['informe/printreducido', 'id' => $model->id , 'estudio' => $model->Estudio_id];
                                  echo    Html::a( "R ", $url, ["class"=>"btn btn-circle btn-teal"] ); ?>
                                <input type="text"value="<?php echo  $model->id ?>" id="id_informe" style="display:none">
                                <input type="text"value="<?php echo $model->Estudio_id ?>" id="id_estudio" style="display:none">
                        </div>
                    </div>
                      
             </div>
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->                 
                <?= $this->render('_form', [
                    'model' => $model, 
                    'edad'=>$modelp->pacienteEdad,
                    'dataproviderMultimedia'=>$dataproviderMultimedia,
                    'codigo'=>$codigo,
                ]) ?>
            </div>
        </div>
            
        </div>
        </div>
    </div>
    
        
</section>
<?php

$this->registerJsFile('@web/assets/admin/js/cipat_modal_informe.js', ['depends' => [yii\web\AssetBundle::className()]]);


    Modal::begin([
                    'id' => 'modal',    
                   // 'size'=>'modal-lg',
                    'options' => ['tabindex' => false ],
                ]);
                echo "<div id='modalContent'></div>";      
    Modal::end();
    

?>
            
