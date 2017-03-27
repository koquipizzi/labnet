<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Procedencias');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    Modal::begin([
            'id' => 'modal',          
            'options' => ['tabindex' => false ],
        ]);
        echo "<div id='modalContent'></div>";
       
    ?> 
    <?php Modal::end();
    
    use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_procedencia.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>
<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
    <div class="body-content animated fadeIn" >    
    <div class="procedencia-index">
        <div class="panel_titulo">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="pull-right">
                    <?= Html::button('Nueva Procedencia', ['value' => Url::to(['procedencia/create']), 'title' => 'Nueva Procedencia', 'class' => 'loadMainContentProcedencia btn btn-success btn-sm']); ?>
                </div>   
                <div class="clearfix"></div>
            </div>
        </div>

    <?php Pjax::begin(['id'=>'procedencias', 'enablePushState' => FALSE]); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Procedencia',
                'format' => 'raw',
                'value' => function ($data, $url) { //var_dump($data); die();
                              return Html::a($data->descripcion, FALSE, ['class' => 'editar', 'value'=>'index.php?r=procedencia/update&id='.$data->id]);
                          },
            ], 
            'telefono',                     
            'domicilio',
            'mail',
            [
                'label' => 'Localidad',   
                'value' => 'localidadTexto',
            ],   
//            [
//                'label' => 'Observaciones',
//                'attribute'=>'informacion_adicional', 
//                'contentOptions' => ['style' => 'width:30%;'],
//            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{edit}{delete}',
            'buttons' => [

            //view button
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-eye "></span>', FALSE, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-success ver btn-xs',
                            'value'=> "$url",
                ]);
            },
            'edit' => function ($url, $model) {
                return Html::a('<span class="fa fa-pencil"></span>', FALSE, [
                            'title' => Yii::t('app', 'Editahhhhhsr'),
                            'class'=>'btn btn-info editar btn-xs',   
                            'value'=> "$url",
                ]);
            },
             'delete' => function ($url, $model) {
                return Html::a('<span class="fa fa-trash"></span>', FALSE, [
                            'title' => Yii::t('app', 'Borrar'),
                            'class'=>'btn btn-danger borrar btn-xs',
                            'value'=> "$url",
                ]);
            },        
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=procedencia/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=procedencia/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=procedencia/delete&id='.$model->id;
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

