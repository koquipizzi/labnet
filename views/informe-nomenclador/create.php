<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InformeNomenclador */

$this->title = Yii::t('app', 'Create Informe Nomenclador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informe Nomencladors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informe-nomenclador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
