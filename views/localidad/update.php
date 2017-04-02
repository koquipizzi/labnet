<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Localidad */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Localidad',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Localidad'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<section id="page-content">

    <div class="header-content">
       <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['localidad/index'],['class'=>'btn btn-primary']) ?>        
    </div><!-- /.header-content -->
    
    <!-- Start body content -->

    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="localidad-update">
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
            
