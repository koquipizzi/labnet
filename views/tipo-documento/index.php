<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoDocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tipo Documentos');
$this->params['breadcrumbs'][] = $this->title;
?>
 <?php 
    Modal::begin([
            'id' => 'activity-modal',             
        ]);
        echo "<div id='modalContent'></div>";
       
    ?> 
    <?php Modal::end();
    
    use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
?>
<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
<div class="body-content animated fadeIn" >    
<div class="tipo-documento-index">
    
    <h4><?= Html::encode($this->title) ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="float:right;">
        <?= Html::a(Yii::t('app', 'Create Tipo Documento'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
     <p>
            <?= Html::button('Nueva tipo', ['value' => Url::to(['tipo-documento/create']), 'title' => 'Nueva Localidad', 'class' => 'loadMainContent btn btn-success']); ?>
        </p>
<?php Pjax::begin(['id' => 'tipo-documento-pjax']); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{edit}{delete}',
            'buttons' => [

            //view button
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-eye "></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-success btn-xs',                                  
                ]);
            },
             'edit' => function ($url, $model) {
                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Editar'),
                            'class'=>'btn btn-info btn-xs',                                  
                ]);
            },
             'delete' => function ($url, $model) {
                return Html::a('<span  class="fa fa-trash"></span>', false, 
                        [
                            'title' => Yii::t('app', 'Eliminar'),
                            'class'=>'btn btn-danger btn-xs',       
                            'onclick' => "//$('#modal').modal('show');
                              if (confirm('Confirma eliminar el elemento?')) {                                                
                                                $.ajax('$url', {
                                                    type: 'POST',
                                                }).done(function(data) {
                                                    $.pjax.reload({container: '#tipo-documento-pjax'});
                                                });
                                            }
                                            return false;
                                        "
                            ]);
            },        
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=tipo-documento/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=tipo-documento/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=tipo-documento/delete&id='.$model->id;
                return $url;
                }
            }
        ],
         ],
    ]); ?>
    
 <?php
    $this->registerJs("
        $(document).on('ready pjax:success', function () {
                $('#activity-modal').addClass('modal-primary');
                $('.loadMainContent').click(function(){     
                    $('#activity-modal').find('.modal-header').html('Nueva Localidad');
                    $('#activity-modal').find('#modalContent').load($(this).attr('value'));
                    $('#activity-modal').modal('show');
                });
                
                $('.editar').click(function(){       
                    $('#activity-modal').find('.modal-header').html('Editar Localidad');
                    $('#activity-modal').find('#modalContent').load($(this).attr('value'));
                    $('#activity-modal').modal('show');
                });
                
                $('.ver').click(function(){       
                    $('#activity-modal').find('.modal-header').html('Ver Localidad');
                    $('#activity-modal').find('#modalContent').load($(this).attr('value'));
                    $('#activity-modal').modal('show');
                });
        });"
            );
    
    Pjax::end(); ?></div>
    </div>
     <!-- Start footer content -->
    <?php echo $this->render('/shares/_footer_admin') ;?>
    <!--/ End footer content -->
</section>

<style>
    .summary{
        float:left;
    }

</style>
