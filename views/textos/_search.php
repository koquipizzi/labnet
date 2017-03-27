<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TextosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="textos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'material') ?>

    <?= $form->field($model, 'tecnica') ?>

    <?= $form->field($model, 'macro') ?>

    <?php // echo $form->field($model, 'micro') ?>

    <?php // echo $form->field($model, 'diagnos') ?>

    <?php // echo $form->field($model, 'observ') ?>

    <?php // echo $form->field($model, 'informe_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
