<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclador */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nomencladors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-pencil"></i> Editar Nomenclador', ['nomenclador/update', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                </div>                                                          <!-- como le paso el id a update ? -->
            </div>              

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'servicio',
                        'descripcion',
                        'valor',
                        'coseguro',
           // 'Prestadoras_id',
                    ],
                ]) ?>
    </div>
