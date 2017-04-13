<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nomenclador */

$this->title = Yii::t('app', 'Create Nomenclador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nomencladors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
              <div class="pull-right">
                            <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['nomenclador/index'], ['class'=>'btn btn-primary']) ?>
              </div>
            </div>
            <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
</div>
