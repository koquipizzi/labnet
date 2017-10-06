<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Textos */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Textos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
    <div class="box-header with-border">
             <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
             <div class="pull-right">
                 <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['textos/index'], ['class'=>'btn btn-primary']) ?>
             </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'codigo',
            'material:ntext',
            'tecnica:ntext',
            'macro:ntext',
            'micro:ntext',
            'diagnos:ntext',
            'observ:ntext',
        ],
    ]) ?>
</div>
