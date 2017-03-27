<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PacientePrestadora */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paciente-prestadora-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nro_afiliado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Paciente_id')->textInput() ?>

    <?= $form->field($model, 'Prestadoras_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
