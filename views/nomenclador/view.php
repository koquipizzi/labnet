<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclador */ 
$this->title = strlen($model->descripcion)<65 ? $model->descripcion : substr($model->descripcion,0, 65)." ....";

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nomencladors'), 'url' => ['index']];
$url = Url::to(['nomenclador/index']);
?>


<div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', $url, ['class'=>'btn btn-primary']) ?> 
                    <?= Html::a('<i class="fa fa-pencil"></i> Editar ', ['nomenclador/update', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                </div>                                                         
            </div>              

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'servicio',
                        'descripcion',
                        'valor',
                        'coseguro',
                        [
                            'label'=>'Prestadora',
                            'value'=>$model->getPrestadoraTexto(),
                        ],
                    ],
                ]) ?>
    </div>
