<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */


$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => 'Prestadoras',]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="box box-info">
            <div class="box-header with-border">
                         <div class="pull-right">
                                <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['procedencia/index'],['class'=>'btn btn-primary']) ?>
                         </div>
                         <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <?= $this->render('_form', [
                    'model' => $model,

                ]) ?>
</div>

<?php
$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Prestadoras',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="box box-info">
    <div class="box-header with-border">
             <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['paciente/index'],['class'=>'btn btn-primary']) ?>
            </div>
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

</div>
