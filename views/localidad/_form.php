<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Localidad */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\rating\StarRating;
?>

    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-localidad-form',
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>

     <?= $form->field($model, 'nombre', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'caracteristica_telefonica', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <div class="form-footer">
        <div style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="reset" class="btn btn-danger" >Restablecer</button>
        </div>
    </div>

        <?php ActiveForm::end(); ?>
    </div>
