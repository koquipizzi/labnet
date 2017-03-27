<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TipoDocumento */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Documentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>        
    </div><!-- /.header-content -->
    
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="tipo-documento-view">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?= Html::encode($this->title) ?>

                        <p style="float: right;">
                        <?=                             Html::a('<span class="fa fa-pencil"></span>', 'index.php?r=tipo-documento/update&id='.$model->id, [
                            'title' => Yii::t('app', ' Editar '),
                            'class'=>'btn btn-info btn-xs',                                  
                ]); ?>
                        <?=                             Html::a('<span class="fa fa-trash "></span>', 'index.php?r=tipo-documento/delete&id='.$model->id, [
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

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
            'descripcion',
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</section>
