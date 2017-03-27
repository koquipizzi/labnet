<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procedencias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
        <div class="verLABnet">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'descripcion',
                        'mail',
                        'domicilio',
                        [
                            'attribute'=>'Localidad',
                            'value'=> $model->getLocalidadTexto(),
                        ],
                    		'telefono'
                    ],
                ]) ?>

        </div>
        <div class="form-footer">
            <div style="text-align: right;">
            <button type="button" class="btn btn-teal" data-dismiss="modal">Cerrar</button>
            </div>         
        </div>

