<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos

use vova07\select2\Widget;

use yii\widgets\Pjax;
//yii fue sustituido por

use kartik\datecontrol\DateControl;
use app\models\Prestadoras;

$this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>

<div class="estudio-form">
    <div class="panel-body no-padding">
        <div class="row col-lg-12 ">
             <div class=" col-lg-12 ">
            <?php
            $form = ActiveForm::begin([
                    'id'=>'createPago'  ,
                    'options' => [
                        'class' => 'form-horizontal mt-10',
                        'id' => 'createPago',
                        'enableAjaxValidation' => true,
                    //    'data-pjax' => '',
             ]
            ]); ?>
           <div class=" col-lg-12 ">
                <div class=" col-lg-3 ">
                    <?php
                    echo $form->field($model, 'fecha',['template' => "{label}
                             <div class='input-group col-md-12' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                             {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                             ])->widget(DateControl::classname(), [
                                 'type'=>DateControl::FORMAT_DATE,
             //                                'ajaxConversion'=>true,
                                 'class' => 'col-md-8',
                                 'options' => [
                                     'pluginOptions' => [
                                         'autoclose' => true
                                     ]
                                 ]
                             ])->error([ 'style' => ' margin-left: 40%;']);
                     ?>
                </div>
                <div class=" col-lg-3 ">
                    <?php
                    echo $form->field($model, 'importe',['template' => "{label}
                            <div class='input-group col-md-12' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                            {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                          ])->textInput()->error([ 'style' => ' margin-left: 40%;'])
                    ?>
                </div>
                <div class=" col-lg-3 ">
                 <?php
                 echo $form->field($model, 'nro_formulario',['template' => "{label}
                         <div class='input-group col-md-12' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                         {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-5  control-label' ],
                       ])->textInput()->error([ 'style' => ' margin-left: 40%;']);
                 ?>
                 </div>
            </div>
            <div class=" col-lg-12 ">
                <div class=" col-lg-3 ">
                     <?php
                     echo $form->field($model, 'fecha_desde',['template' => "{label}
                             <div class='input-group col-md-12' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                             {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                             ])->widget(DateControl::classname(), [
                                 'type'=>DateControl::FORMAT_DATE,
             //                                'ajaxConversion'=>true,
                                 'class' => 'col-md-8',
                                 'options' => [
                                     'pluginOptions' => [
                                         'autoclose' => true
                                     ]
                                 ]
                             ])->error([ 'style' => ' margin-left: 40%;']);
                     ?>
                </div>
                <div class=" col-lg-3 ">
                    <?php
                    echo $form->field($model, 'fecha_hasta',['template' => "{label}
                             <div class='input-group col-md-12' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                             {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                             ])->widget(DateControl::classname(), [
                                 'type'=>DateControl::FORMAT_DATE,
             //                                'ajaxConversion'=>true,
                                 'class' => 'col-md-8',
                                 'options' => [
                                     'pluginOptions' => [
                                         'autoclose' => true
                                     ]
                                 ]
                             ])->error([ 'style' => ' margin-left: 40%;']);
                     ?>
                </div>
                <div class=" col-lg-3 ">
                     <?php
                     $data=ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion');
                     echo $form->field($model, 'Prestadoras_id',
                             ['template' => "{label}
                             <div class='input-group col-md-12' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                             {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                             ]
                             )->widget(Widget::className(), [
                             'options' => [
                                 'multiple' => false,
                                 'prompt' => 'Seleccionar Prestadora',
                             ],
                                 'items' => $data,
                             'settings' => [
                                 'width' => '100%',
                             ],
                         ]);
                     ?>
                </div>



             </div>
        </div>

    <div class=" row col-lg-12 ">
        <div class="panel-body no-padding">

            <div id=""  class='form-body'>
                <div style="text-align: left; margin-left: 2%">
                    <h5>Seleccionar Informes</h5>
                </div>
                <div id="grillaPago" class="col-md-12 ">

                <?= $this->render('grilla', [
                    'dataProvider'=>$dataProvider,
                    'searchModel'=> $searchModel
                ]) ?>

                 </div>
            </div>
           </div>
        </div>
        <div class=" row col-lg-12">
            <div  style="padding-left:1%; width:99%; ">
            <?php
                 echo   $form->field($model, 'observaciones', ['template' => "{label}
                    <div class='input-group col-md-12' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                    {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-5  control-label' ],
                    ])->textArea(['maxlength' => false])->error([ 'style' => ' margin-left: 40%;'])
            ?>
           </div>
            </div>
        <div class="row form-group" >
                  <div style="text-align: right;">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=> 'enviar_pago']) ?>
                </div>
        </div>
            <?php ActiveForm::end(); ?>


        </div>
    </div>
</div>

 <?php
?>
