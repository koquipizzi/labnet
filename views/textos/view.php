<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Textos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Textos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="page-content">

    <div class="header-content">
    <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left""></i> Volver', ['textos/index'], ['class'=>'btn btn-primary']) ?>
    </div>  
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>
    </div><!-- /.header-content -->

    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="protocolo-view">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?= Html::encode($this->title) ?>

                        <p style="float: right;">
                            <?=                             Html::a('<span class="fa fa-pencil"></span>', 'index.php?r=protocolo/update&id='.$model->id, [
                                'title' => Yii::t('app', ' Editar '),
                                'class'=>'btn btn-info btn-xs',
                            ]); ?>
                            <?=                             Html::a('<span class="fa fa-trash "></span>', 'index.php?r=protocolo/delete&id='.$model->id, [
                                'class' => 'btn btn-danger btn-xs',
                                'title' => Yii::t('app', ' Eliminar '),
                                'data' => [
                                    'confirm' => Yii::t('app', 'Está seguro que quiere eliminar este item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>
                    </h3>
                </div>
            </div>
        </div>

                <div class="col-md-12">
                    <div class="panel  shadow">
                        
                        <div class="panel-body text-center">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'material:ntext',
            'tecnica:ntext',
            'macro:ntext',
            'micro:ntext',
            'diagnos:ntext',
            'observ:ntext',
        ],
    ]) ?>

</div> </div>
                    </div>
                </div>



