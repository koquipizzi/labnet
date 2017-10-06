<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */
$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entidades Facturables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
       <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['prestadoras/indexfacturable'], ['class'=>'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-pencil"></i> Editar ', ['prestadoras/updatefacturable', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                </div>
        </div>
        <div class="verLABnet">
              <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'descripcion',
                        'domicilio',
                        [
                            'attribute'=>'Localidad',
                            'value'=> $model->getLocalidadTexto(),
                        ],
                        'telefono',
                        'email:email',
                        'notas',

                    ],
                ]) ?>

        </div>
</div>
