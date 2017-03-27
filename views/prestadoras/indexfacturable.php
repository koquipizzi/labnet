<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use app\models\TipoPrestadora;
use app\models\Localidad;


$this->title = Yii::t('app', 'Entidades Facturables');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Modal::begin([
    'id' => 'modal',
    'options' => [
        'tabindex' => false]
]);
echo "<div id='modalContent'></div>";

?>
<?php Modal::end();

use app\assets\admin\dashboard\DashboardAsset;
DashboardAsset::register($this);


$this->registerJsFile('@web/assets/admin/js/cipat_modal_facturable.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>



<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>
    </div><!-- /.header-content -->

    <div class="body-content animated fadeIn" >
        <div class="prestadoras-index">
            <div class="panel_titulo">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                    </div>
                    <div class="pull-right">
                        <?= Html::button('Nueva Entidad Facturable', ['value' => Url::to(['prestadoras/createfacturable']), 'title' => 'Nuevo Facturable', 'class' => 'loadMainContentPrestadora btn btn-success btn-sm']); ?>
                    </div>   
                    <div class="clearfix"></div>
                </div>
            </div>

            <?php Pjax::begin(['id' => 'prestadoras']); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options'=>array('class'=>'table table-striped table-lilac'),
                'filterModel' => $searchModel,
                //  'pjax' => true,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'descripcion',
                    [                
                        'attribute'=>'telefono', 
                        'contentOptions' => ['style' => 'width:10%;'],
                    ],    
                    'email:email',
                    
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{edit}{delete}',
                        'buttons' => [

                            //view button
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye activity-view-link"></span>', false, [
                                    'title' => Yii::t('app', 'Ver'),
                                    'class'=>'btn btn-success btn-xs ver',
                                    'value'=> "$url",
                                ]);
                            },
                            'edit' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil"></span>', false, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'class'=>'btn btn-info btn-xs editar',
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
                                    $url ='index.php?r=prestadoras/viewfacturable&id='.$model->id;
                                    return $url;
                                                  }
                                   if ($action === 'edit') {
                                        $url ='index.php?r=prestadoras/updatefacturable&id='.$model->id;
                                         return $url;
                                          }
                                       if ($action === 'delete') {
                                            $url ='index.php?r=prestadoras/deletefacturable&id='.$model->id;
                                            return $url;
                                             }
                                          }
                    ],
                ],
            ]); ?>


            <?php


            Pjax::end(); ?>

        </div>
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



