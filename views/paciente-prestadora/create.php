<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PacientePrestadora */

$this->title = Yii::t('app', 'Create Paciente Prestadora');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Paciente Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-prestadora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
