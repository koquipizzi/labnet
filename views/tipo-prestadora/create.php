<?php
use app\assets\admin\dashboard\DashboardAsset;
DashboardAsset::register($this);

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoPrestadora */

$this->title = Yii::t('app', 'Create Tipo Prestadora');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="tipo-prestadora-create">
                <div class="panel-heading">
                                   <div class="pull-left">
                                       <h3 class="panel-title"><?= Html::encode($this->title) ?><code></code></h3>
                                   </div>
                                   <div class="pull-right">
                                                 <?= Html::a('<i class="fa fa-pencil"></i> Volver', ['tipo-prestadora/index'], ['class'=>'btn btn-primary']) ?>
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
