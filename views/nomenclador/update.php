<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclador */

$this->title = strlen($model->descripcion)<65 ? $model->descripcion : substr($model->descripcion,0, 65)." ....";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nomencladors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->servicio, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="box box-info">
            <div class="box-header with-border">
             <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['nomenclador/index'],['class'=>'btn btn-primary']) ?>
                </div>
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <?= $this->render('_form', [
                    'model' => $model,

                ]) ?>
</div>
