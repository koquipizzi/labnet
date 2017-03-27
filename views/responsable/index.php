<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ResponsableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Responsables');
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
    <div class="body-content animated fadeIn" >    
    <div class="responsable-index">
        <div class="panel_titulo">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="pull-right">
                    <?= Html::a(Yii::t('app', 'Create Responsable'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>   
                <div class="clearfix"></div>
            </div>
        </div>
    
    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="float:right;">
        <?= Html::a(Yii::t('app', 'Create Responsable'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',

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
                $url ='index.php?r=responsable/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=responsable/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=responsable/delete&id='.$model->id;
                return $url;
                }
            }
        ],
         ],
    ]); ?>
<?php Pjax::end(); ?></div>
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
