<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Localidad */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Localidads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="verLABnet">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'nombre',
                'cp',
                'caracteristica_telefonica'
            ],
        ]) ?>
    </div>
    <div class="form-footer">
        <div style="text-align: right;">
        <button type="button" class="btn btn-teal" data-dismiss="modal">Cerrar</button>
        </div>         
    </div>



