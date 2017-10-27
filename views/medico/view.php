<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medico */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Medicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
       <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['medico/index'], ['class'=>'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-pencil"></i> Editar ', ['medico/update', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                </div>
            </div>
            <?=  DetailView::widget(['model' => $model,'attributes' => [
                            'nombre',
                            'email:email',
                            [
                            'label'=>'Especialidad',
                            'value'=>$model->getEspecialidadTexto(),
                            ],
                            'domicilio',
                            'telefono',
                             [
                            'label'=>'Localidad',
                            'value'=>$model->getLocalidadTexto(),
                            ],
                            'notas'
                             ]
                     ])
        ?>
</div>




    <!--div class="form-footer">
        <div style="text-align: right;">
        <button type="button" class="btn btn-teal" data-dismiss="modal">Cerrar</button>
        </div>
    </div-->
