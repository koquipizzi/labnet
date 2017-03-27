<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Textos */

$this->title = Yii::t('app', 'Nuevo AutoTexto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'AutoTextos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<section id="page-content">
<?php     
    use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
?>
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>        
    </div><!-- /.header-content -->
   
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="localidad-create">
                <div class="panel-heading">
                                   <div class="pull-left">
                                       <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                                   </div>
                                   <div class="pull-right">
                                       <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                                       <button class="btn btn-sm" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Remove"><i class="fa fa-times"></i></button>
                                   </div>
                    
                                   <div class="clearfix"></div>
                </div><!-- /.panel-heading -->   

                <?= $this->render('_form', [
                    'model' => $model
                ]) ?>

            </div>
        </div>
    </div>
</section>   

