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
/*use yii\jui\AutoComplete;
use yii\web\JsExpression;*/
use yii\widgets\Pjax;
//yii fue sustituido por
//use kartik\select2\Select2;
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

$this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>
<div class="box-body">
<?php

    $form = ActiveForm::begin(['id'=>'create-paciente-form'  ,   
                'options' => [
                    'class' => 'form-horizontal mt-10',
                    'id' => 'create-paciente-form',
                    'enableAjaxValidation' => true,
                //    'data-pjax' => '',
                ]
            ]); 
    ?>
   <div class="row ">
                <div class="col-md-1" style="text-align: right;">
                    <h4>Nro</h4>
                </div>            
                <div class="col-md-11">
                    <div class="col-md-4">
                                <div class="col-md-4 ">
                                 <?= $form->field($model, 'anio', ['template' => "
                                                         <div class=''>{input}</div>
                                                         {hint}
                                                         {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-0  ' ]
                                   ])->textInput(['maxlength' => false]) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model, 'letra', ['template' => "
                                                                <div class='' placeholder='Letra'>{input}</div>
                                                                {hint}
                                                                {error}",
                                                                'labelOptions' => [ 'class' => 'col-md-0' ]                                        
                                    ])->textInput(['maxlength' => false]) ?>
                                </div>
                                <div class="col-md-5">
                                    <?= $form->field($model, 'nro_secuencia',['template' => "
                                                        <div>{input}</div>
                                                        {hint}
                                                        {error}",
                              ])->textInput() ?>
                                </div>
                </div> 
   </div> 
    <div class="row ">
        <?php
             $data=ArrayHelper::map(ViewPacientePrestadora::find()->asArray()->all(), 'id', 'nombreDniDescripcionNroAfiliado');
                 echo $form->field($model, 'Paciente_prestadora_id',
                                    ['template' => "{label}
                                    <div class=' col-md-10' >                
                                    {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-2  control-label' ],                
                                    ]
                                    )->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => false,
                                        'placeholder' => 'Choose item'
                                    ],
                                        'items' => $data,
                                    'settings' => [
                                        'width' => '100%',
                                    ],
                            ]); 
                            
     ?>
    </div>





<?php ActiveForm::end(); ?>