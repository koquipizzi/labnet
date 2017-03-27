<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclador */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nomencladors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="verLABnet">                 

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

    <div class="form-footer">
        <div style="text-align: right;">
        <button type="button" class="btn btn-teal" data-dismiss="modal">Cerrar</button>
        </div>         
    </div>