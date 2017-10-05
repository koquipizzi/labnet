<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = "Paciente: ".$model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];

?>

<div class="box box-info">
        <div class="box-header with-border">
                        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                        <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['paciente/index'], ['class'=>'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-pencil"></i> Editar ', ['paciente/update', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                </div>
        </div>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' =>
                    [
                        'nombre',
                        'nro_documento',
                        [
                            'label'=>'Género',
                            'value'=>$model->getGeneroTexto(),
                        ],
                        [
                            'attribute' => 'fecha_nacimiento',
                            'format' => ['date', 'php:d/m/Y']
                        ],
                        'telefono',
                        'email:email',
                        'domicilio',
                        [
                            'label'=>'Localidad',
                            'value'=>$model->getLocalidadTexto(),
                        ],

                    ],
                ]) ?>
</div>
