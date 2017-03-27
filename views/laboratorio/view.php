<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Laboratorio */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laboratorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    
<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>
    </div><!-- /.header-content -->

    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="localidad-update">
                <div class="panel-heading">
                    <div class="pull-left">
                       <h3 class="panel-title"><?= Html::encode($this->title) ?><code></code></h3>
                    </div>
                    <div class="pull-right">                                    
                        <?= Html::a(Yii::t('app', 'Modificar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </div>               
                    <div class="clearfix"></div>                                   
                </div><!-- /.panel-heading -->                 
                

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [                        
                        'nombre',
                        'descripcion',
                        'admin',
                       // 'path_logo',
                        'direccion',
                        'web',
                        'telefono',
                        'mail',
                        'info_mail',
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</section>
