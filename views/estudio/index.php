<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EstudioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estudios');
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
<div class="body-content animated fadeIn" >    
<div class="estudio-index">
    
    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="float:right;">
        <?= Html::a(Yii::t('app', 'Create Estudio'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion',
            'nombre',
            'titulo',
            'columnas',
            // 'template',

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
                return Html::a('<span class="fa fa-trash"></span>', $url, [
                            'title' => Yii::t('app', 'Borrar'),
                            'class'=>'btn btn-danger btn-xs',                                  
                ]);
            },        
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=estudio/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=estudio/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=estudio/delete&id='.$model->id;
                return $url;
                }
            }
        ],
         ],
    ]); ?>
<?php Pjax::end(); ?></div>
    </div>
</section>

<style>
    .summary{
        float:left;
    }

</style>
