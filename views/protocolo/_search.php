<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProtocoloSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="protocolo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha_entrada') ?>

    <?= $form->field($model, 'anio') ?>

    <?= $form->field($model, 'letra') ?>

    <?= $form->field($model, 'nro_secuencia') ?>

    <?php // echo $form->field($model, 'registro') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'Medico_id') ?>

    <?php // echo $form->field($model, 'Procedencia_id') ?>

    <?php // echo $form->field($model, 'Paciente_prestadora_id') ?>

    <?php // echo $form->field($model, 'FacturarA_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
