<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

$this->title = Yii::t('app', 'Create Tarifas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarifas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="tarifas-create">
                <div class="panel-heading">
                                   <div class="pull-left">
                                       <h3 class="panel-title"><?= Html::encode($this->title) ?><code></code></h3>
                                   </div>
                                   <div class="pull-right">
                                       <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['tarifa/index'], ['class'=>'btn btn-primary']) ?>
                                   </div>
                                   <div class="clearfix"></div>
                </div><!-- /.panel-heading -->

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
