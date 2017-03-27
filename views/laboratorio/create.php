<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Laboratorio */

$this->title = Yii::t('app', 'Create Laboratorio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laboratorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="laboratorio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
