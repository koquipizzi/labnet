<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
    <div class="form-footer">
        <div style="text-align: right;">
        <button type="button" class="btn btn-teal" data-dismiss="modal">Cerrar</button>
        </div>         
    </div>
