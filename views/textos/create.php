<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Textos */

$this->title = Yii::t('app', 'Nuevo AutoTexto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'AutoTextos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<section id="page-content">
    <div class="header-content">
    <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left""></i> Volver', ['textos/index'], ['class'=>'btn btn-primary']) ?>
    </div>  
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
                                     <div class="clearfix"></div>
                </div><!-- /.panel-heading -->   

                <?= $this->render('_form', [
                    'model' => $model
                ]) ?>

            </div>
        </div>
    </div>
</section>   

