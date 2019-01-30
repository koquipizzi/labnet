<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Localidad */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'legend'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
    <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-pencil"></i> Volver', ['leyenda/index'], ['class'=>'btn btn-primary']) ?>
            </div>
    </div>            
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'texto',
            'categoria'
        ],
    ]) ?>
</div>
