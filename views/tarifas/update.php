<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tarifas',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarifas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="tarifas-update">
                <div class="panel-heading">
                                   <div class="pull-left">
                                       <h3 class="panel-title"><?= Html::encode($this->title) ?><code></code></h3>
                                   </div>
                                   <div class="clearfix"></div>
                </div><!-- /.panel-heading -->


                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</section>
