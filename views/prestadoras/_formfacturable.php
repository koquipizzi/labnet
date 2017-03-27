<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Localidad;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */
/* @var $form ActiveForm */
?>
<div class="prestadoras-_form">

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

    <div class="form-footer">
        <div style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- prestadoras-_form -->
