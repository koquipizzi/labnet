<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\HistorialPaciente */

$this->title = 'Create Historial Paciente';
$this->params['breadcrumbs'][] = ['label' => 'Historial Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-paciente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
