<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Localidad */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Localidad'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="box box-info">
       <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-pencil"></i> Volver', ['localidad/index'], ['class'=>'btn btn-primary']) ?>
                </div>                                                         
            </div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'nombre',
                'cp',
                'caracteristica_telefonica'
            ],
        ]) ?>
    </div>



