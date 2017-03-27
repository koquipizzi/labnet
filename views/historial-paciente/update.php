<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialPaciente */

$this->title = 'Update Historial Paciente: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Historial Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historial-paciente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
