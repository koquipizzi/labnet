

<?php
use yii\helpers\Html;
/* @var $this yii\web\View */


$this->title = Yii::t('app', 'Nuevo Pago');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



?>

<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>        
    </div><!-- /.header-content -->
    
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="pago-create">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                    </div>                                   
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->   

                <?= $this->render('_form', [
                    'model' => $model,
                    'dataProvider'=>$dataProvider,
                    'searchModel'=> $searchModel
                ]) ?>
            </div>
        </div>
    </div>
</section>    
