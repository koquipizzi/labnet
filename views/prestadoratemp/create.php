<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PrestadoraTemp */

$this->title = Yii::t('app', 'Create Prestadora Temp');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prestadora Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestadora-temp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
