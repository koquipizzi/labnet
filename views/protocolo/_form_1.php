<?php

use yii\bootstrap\Modal;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;
//yii fue sustituido por
use kartik\select2\Select2;
use vova07\select2\Widget;
use kartik\datecontrol\DateControl;
//Models
use app\models\Estudio;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use app\models\Medico;
use app\models\ViewPacientePrestadora;
use app\models\ViewPacientePrestadoraQuery;
use app\models\Prestadoras;
use app\models\InformeTemp;
/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
if (!$session->isActive) 
                // open a session
    $session->open();
  
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
  <div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i>Saved!</h4>
  <?= Yii::$app->session->getFlash('success') ?>
  </div>
<?php endif; ?>

<?= Html::csrfMetaTags() ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $paciente->nombre." ( ".$prestadora->descripcion." )";  ?></h3>
    </div>
                         
    <div class="box-body">
        <?php $form = ActiveForm::begin([ 
                    'id'  => 'form-protocolo',
                    'options' => [
                        'class' => 'form-horizontal mt-10',
                        'id' => 'form-protocolo',
                        'enableAjaxValidation' => true,
                        'data-pjax' => '',
                    ]
            ]); ?>
                <input type="hidden" name="tanda" value="<?= $tanda ?>" id="tanda">
 
        <div class="col-md-6" style="text-align: right;">
            <div class="col-md-4" style="text-align: right;">
                <h5><strong>Nro</strong></h5>
            </div> 
                    <div class="col-md-2">
            <?= $form->field($model, 'anio', ['template' => "
                                            <div class=''>{input}</div>
                                            {hint}
                                            {error}",
                                           'labelOptions' => [ 'class' => 'col-md-1 ' ]
                      ])->textInput(['maxlength' => false]) ?>
         </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'letra', ['template' => "
                                                <div class='' placeholder='Letra'>{input}</div>
                                                {hint}
                                                {error}",
                                                'labelOptions' => [ 'class' => 'col-md-2' ]                                        
                    ])->textInput(['maxlength' => false]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'nro_secuencia',['template' => "
                                        <div>{input}</div>
                                        {hint}
                                        {error}",
              ])->textInput() ?>
                </div>

                       <?= $form->field($model, 'numero_hospitalario',['template' => "{label}
                                             <div class='col-md-7'>{input}</div>
                                             {hint}
                                             {error}",
                                              'labelOptions' => [ 'class' => 'col-md-4 control-label' ]
                 ])->textInput()->error([ 'style' => ' text-align: center;'])?>

                 <?=$form->field($model, 'fecha_entrada',['template' => "{label}
                            <div class='col-md-7' >                
                            {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                            ])->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                ])->error([ 'style' => ' text-align: center;']); ?>
            
                <?php
                echo $form->field($model, 'fecha_entrega',['template' => "{label}
                <div class='col-md-7' >                
                {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                ])->widget(DateControl::classname(), [
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>true,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ])->error();
                ?>

            <?php   $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');

            echo $form->field($model, 'Medico_id',
                                    ['template' => "{label}
                                    <div class='col-md-7' >                
                                    {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                                    ]
                        )->widget(Widget::className(), [
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Choose item'
                ],
                    'items' => $dataMedico ,
                    'settings' => [
                        'class'=> 'form-group',
                    'width' => '100%',
                    ]
            ]);               
            ?>
            <?php   
                $dataProcedencia=ArrayHelper::map(Procedencia::find()->asArray()->all(), 'id', 'descripcion');
                
                echo $form->field($model, 'Procedencia_id',
                        ['template' => "{label}
                        <div class='col-md-7'>                
                        {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                        ]
                        )->widget(Widget::className(), [
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Choose item'
                ],
                    'items' => $dataProcedencia,
                'settings' => [
                    'width' => '100%',
                ]
            ]);
            
                $dataFacturar=ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion');
            
                echo $form->field($model, 'FacturarA_id',
                        ['template' => "{label}
                        <div class='col-md-7'>                
                        {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                        ]
                        )->widget(Widget::className(), [
                        'options' => [
                            'multiple' => false,
                            'placeholder' => 'Choose item'
                        ],
                        'items' => $dataFacturar,
                        'settings' => [
                            'width' => '100%',
                        ]
                ]);

                echo $form->field($model, 'observaciones', ['template' => "{label}
                                <div class='col-md-7'>{input}</div>
                                {hint}
                                {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                    ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-left: 40%;']);
                 
                $this->registerCss('
                    .select2-container-multi {
                        margin: 0;
                        padding: 0;
                        white-space: nowrap;
                        width:96%;
                        margin-left: 15px;
                    }
                    .select2-default {
                        color: #000 !important; 
                    }

                    .select2-container-multi .select2-choices .select2-search-field input {
                        padding: 5px;
                        margin: 1px 0;
                        font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;
                        font-size: 100%;
                        outline: 0;
                        border: 0;
                        -webkit-box-shadow: none;
                        box-shadow: none;
                        background: transparent !important;
                    }

                ');

                    ?>
                    <div class="row form-group" >
            <div style="text-align: right;">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=> 'enviar_paciente']) ?>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>  
        </div>
   
        <?php ActiveForm::end(); ?>
        </div> <!-- bloque izquierdo -->
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Estudios</h3>
                <div class="box-tools">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
              </div>
                
              </div>
                </div>
                <div class="box-body">
                 <form onsubmit="return false;" data-pjax ="true" id="create-informeTemp-form" 
                action="index.php?r=informetemp/create" method="POST" class="form-horizontal">
                
                <?php 
                    $form2 = ActiveForm::begin([ 
                            'id'  => 'create-informeTemp-form',
                            'options' => [
                                'class' => 'form-horizontal mt-10',
                                'id' => 'create-informeTemp-form',
                                'enableAjaxValidation' => true,
                                'data-pjax' => '',
                            ]
                    ]);
                    $informe = new InformeTemp();
                    $dataEstudio=ArrayHelper::map(Estudio::find()->asArray()->all(), 'id', 'descripcion');
                    echo $form2->field($informe, 'Estudio_id',['template' => "{label}
                                    <div class='col-md-8 id='sel_estudio'>{input}</div>
                                    {hint}
                                    {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                        ])->dropDownList(
                            $dataEstudio, 
                            ['prompt'=>'Seleccionar Estudio'],
                            ['id'=>'descripcion'],
                            [ 'class' => ' chosen-container chosen-container-single chosen-container-active' ]       
                    );

                   echo $form->field($informe, 'descripcion', ['template' => "{label}
                    <div class='col-md-8'>{input}</div>
                    {hint}
                    {error}",
                    'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                 ])->textInput(['maxlength' => true]); 

                    echo $form2->field($informe, 'observaciones', ['template' => "{label}
                    <div class='col-md-8'>{input}</div>
                    {hint}
                    {error}",
                    'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->textInput(['maxlength' => true]);
                 ?>
		
                <div id="selector-servicio_refresh">                
                    <?php        
                        echo $form2->field($nomenclador, 'servicio',
                            ['template' => "{label}
                            <div class='input-group col-md-8'  >                
                            {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                            ]
                            )->widget(Widget::className(), [
                            'options' => [
                                'multiple' => true,
                                'placeholder' => 'Seleccione nomencladores',
                                'class'=>'selNom'
                            ],
                                'items' => $nomenclador->getdropNomenclador(),
                            'settings' => [
                               
                            ],
                        ]);
                    ?>
                 </div> 
                 <?php 
                 echo $form2->field($informe, 'tanda')->hiddenInput(['value'=> $tanda])->label(false); 
           //      echo $form2->field($informe, 'Protocolo_id')->hiddenInput(['value'=> $model->id])->label(false);
                 Html::a('<span class="fa fa-trash"></span>', FALSE, [
                                                    'title' => Yii::t('app', 'Borrar'),
                                                    'class'=>'btn btn-danger btn-xs', 
                                                    'onclick'=>'send()', 
                                                
                                        ]);?>
                
                <div class="form-footer" style="text-align:right;">  

                        <?php 
                        echo Html::a('Agregar Informe', FALSE, ['class' => 'btn btn-primary addInforme']);
                        ?>
                </div>  
                 <form> 
                 <?php //ActiveForm::end(); ?>
                </div>
            
                <div id="estudiosInformeTemp">
                        <?= $this->render('//protocolo/_grid', [
                             'dataProvider' => $dataProvider,'tanda' => $tanda,'model'=>$informe,
                        ]) ?>      
                </div>
                 <?php /* echo $this->render('//protocolo/_gridInforme', [
                                                        'dataProvider' => $dataProvider,'model'=>$model,
                                                ]) */ ?> 
                                             
                                             
        </div> <!-- bloque derecho -->
                   


    </div>
</div>

<div class="protocolo-form">
    <div class="panel-body no-padding">
        
              
                    
                     <?php echo $form->field($model, 'Paciente_prestadora_id')->hiddenInput(['value'=> $pacprest])->label(false); ?>
        
        <div class="row form-group">
        <div class="col-lg-6">
        

            <input type="hidden" name="tanda" value="0" id="hiddenInformeTemp">
 
        
    </div>

    <div class="col-lg-6 panel rounded shadow">
        
            
                
                
                
            </div>
        </div>
        </div>
          
        </div>  
      </div>  
      </div>  

<?php
  $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>