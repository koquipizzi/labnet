<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InformeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'observaciones') ?>

    <?= $form->field($model, 'material') ?>

    <?= $form->field($model, 'tecnica') ?>

    <?php // echo $form->field($model, 'macroscopia') ?>

    <?php // echo $form->field($model, 'microscopia') ?>

    <?php // echo $form->field($model, 'diagnostico') ?>

    <?php // echo $form->field($model, 'Informecol') ?>

    <?php // echo $form->field($model, 'Estudio_id') ?>

    <?php // echo $form->field($model, 'Protocolo_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
