<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Localidad;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */
/* @var $form ActiveForm */
/*$this->title = Yii::t('app', 'Nueva Cobertura/OS');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Coberturas/OS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
*/

        $js =" 

            $('.addModalPrestadora').click( function (e) {
                var form = $('form#create-prestadora-form');
                $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: form.serialize(),
        success: function (data) {
            
            if (data.result == 'ok') {     
                var n = noty({
                    text: 'Se agregó la nueva prestadora',
                    type: 'success',
                    class: 'animated pulse',
                    layout: 'topRight',
                    theme: 'relax',
                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                    force: false, // adds notification to the beginning of queue when set to true
                    modal: false, // si pongo true me hace el efecto de pantalla gris
                });
                $('#modal').modal('toggle');

            }
            else
                if (data.result == 'error') {
                    {
                        var n = noty({
                            text: data.mensaje,
                            type: 'error',
                            class: 'animated pulse',
                            layout: 'topRight',
                            theme: 'relax',
                            timeout: 3000, // delay for closing event. Set false for sticky notifications
                            force: false, // adds notification to the beginning of queue when set to true
                            modal: false, // si pongo true me hace el efecto de pantalla gris
                        });
                    }
            }
           
        },
        error: function () {
            console.log('internal server error');
        }
    });

        }); ";
        
        $this->registerJs($js);
?>



<div class="">
            <!--div class="box-header with-border">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
              <div class="pull-right">
                            <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['prestadoras/index'], ['class'=>'btn btn-primary']) ?>
              </div>
            </div-->
            <?php $form = ActiveForm::begin([  'id'=>'create-prestadora-form',
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id'=>'create-prestadora-form',
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>

    <?= $form->field($model, 'descripcion', ['template' => "{label}
                                            <div class='col-md-7'>{input}</div>
                                            {hint}
                                            {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true])
    ?>


    <?= $form->field($model, 'domicilio', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?php
    $data=ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');

    echo $form->field($model, 'Localidad_id', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",  'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->widget(select2::classname(), [
        'data' => $data,
        'language'=>'es',
        'options' => ['placeholder' => 'Seleccione una Localidad ...'],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]);
    ?>


        <?= $form->field($model, 'facturable',['template' => "{label}
                                <div class='col-md-7'>{input}</div>
                                {hint}
                                {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->dropDownList(['1' => 'Si', '0' => 'No'],['prompt'=>'Seleccionar Opción']);
?>


    <?= $form->field($model, 'telefono', ['template' => "{label}
                                <div class='col-md-7'>{input}</div>
                                {hint}
                                {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email', ['template' => "{label}
                            <div class='col-md-7'>{input}</div>
                            {hint}
                            {error}",

        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'notas', ['template' => "{label}
                            <div class='col-md-7'>{input}</div>
                            {hint}
                            {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textArea(['maxlength' => true]) ?>

    <div class="modal-footer">
       <?php echo Html::button(('Guardar'), ['class' => 'btn btn-success addModalPrestadora']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>

    <?php ActiveForm::end(); ?>

</div>
