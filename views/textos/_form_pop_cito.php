<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use yii\web\JsExpression;
use execut\widget\TreeView;
use app\controllers\AutoTextTreeController;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Workflow;
use kartik\editable\Editable;
use kartik\popover\PopoverX;

echo \yii::$app->request->get('page');

$js= new JsExpression(<<<JS
$("body").on("submit", "form#create-autotexto-formCito", function (e) {
    $("body").keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
    
    e.preventDefault();
    e.stopImmediatePropagation();
    var form = $(this);
    // return false if form still have some validation errors
    if (form.find(".has-error").length)
    {
        return false;
    }
    // submit form
    $.ajax({
                    url    : form.attr("action"),
                    type   : "post",
                    data   : form.serialize(),
                    success: function (response)
                    {

                        if (response.rdo == 'ko'){
                            var n = noty({
                                text: 'El código debe ser único',
                                type: 'error',
                                killer: true,
                                class: 'animated pulse',
                                layout: 'topRight',
                                theme: 'relax',
                                timeout: 3000, // delay for closing event. Set false for sticky notifications
                                force: false, // adds notification to the beginning of queue when set to true
                                modal: false, // si pongo true me hace el efecto de pantalla gris
                            });
                            return false;
                        }

                        else {
                            //   $.pjax.reload({container:'#pjax-tree'});
                            $("#modal").modal("toggle");
    
                            //   $.pjax.reload({container:"#pacientes"}); //for pjax update
                            var n = noty({
                                   text: 'Autotexto generado con éxito!',
                                   type: 'success',
                                   class: 'animated pulse',
                                   layout: 'topRight',
                                   theme: 'relax',
                                   killer: true,
                                   timeout: 3000, // delay for closing event. Set false for sticky notifications
                                   force: false, // adds notification to the beginning of queue when set to true
                                   modal: false, // si pongo true me hace el efecto de pantalla gris
                            });
                               $.pjax.reload({container:"#pjax-container"});
                        }
                    },
                    error  : function () {
        console.log("internal server error");
    }
            });
        return false;
});
$( ".modal_close" ).click(function() {
   $('#modal').modal('hide');
});


JS
    );
    
$this->registerJs($js);
?>
<div class="panel-body no-padding">

    <?php 
        $url= Yii::$app->getUrlManager()->createUrl('textos/customtext') ;
        $form = ActiveForm::begin([             
            'action' =>$url,
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-autotexto-formCito',
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>

       <?php //die($model->estudio_id);
    

          
            $data=ArrayHelper::map(\app\models\Estudio::find()->asArray()->all(), 'id', 'nombre');   
            
            echo $form->field($model, 'estudio_id', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",  'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
                ])->widget(select2::classname(), [
                            'data' => $data,
                            'disabled' => true,
                            'language'=>'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de Estudio ...'],
                            'pluginOptions' => [
                                'allowClear' => false
                                ],
                            ])->error([ 'style' => ' margin-right: 30%;']);
                            
                            ?>
    
        
        <?= $form->field($model, 'codigo', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textInput(['maxlength' => true]) ?>


    
    <?= $form->field($model, 'material', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'tecnica', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'micro', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6])->label('Descripción Citológica') ?>
    
    <?= $form->field($model, 'diagnos', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'observ', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    <?php
              echo $form->field($model, 'estudio_id')->hiddenInput(['value'=> $model->estudio_id])->label(false);
    ?>

    <div class="form-footer">
        <div class="col-sm-offset-3">
            <div style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary enviar_autotexto' : 'btn btn-primary enviar_autotexto']) ?>
             <button type="reset" class="btn btn-default ">Restablecer</button>
             <button type="reset" class="btn btn-danger  modal_close">Cerrar</button>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
