<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */
$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
       <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-pencil"></i> Volver', ['prestadoras/index'], ['class'=>'btn btn-primary']) ?>
                </div>
        </div>
        <div class="verLABnet">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'descripcion',
                        'telefono',
                        'domicilio',
                        'email:email',
                        [
                            'attribute'=>'Localidad',
                            'value'=> $model->getLocalidadTexto(),
                        ],
                        [
                            'attribute'=>'Facturable',
                            'value'=> $model->getFacturableTexto(),
                        ], 
                        [
                            'attribute'=>'Tipo Prestadora',
                            'value'=> $model->getTipoPrestadoraTexto(),
                        ],                        
                    ],
                ]) ?>

        </div>
</div>
