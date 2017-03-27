<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PrestadorasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prestadoras-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'telefono') ?>

    <?= $form->field($model, 'domicilio') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'Localidad_id') ?>

    <?php // echo $form->field($model, 'facturable') ?>

    <?php // echo $form->field($model, 'Tipo_prestadora_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
