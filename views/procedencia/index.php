<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use xj\bootbox\BootboxAsset;
use yii\helpers\ArrayHelper;
use app\models\Localidad; 

BootboxAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Procedencias');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/assets/admin/js/cipat_modal_procedencia.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>
    <div class="header-content">
         <div class="pull-left">
             <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
         </div>
         <div class="pull-right">
             <?= Html::a('<i class="fa fa-plus-circle"></i> Nueva Procedencia', ['procedencia/create'], ['class'=>'btn btn-primary']) ?>
         </div>
         <div class="clearfix"></div>
     </div>

    <?php Pjax::begin(['id'=>'procedencias', 'enablePushState' => FALSE]); ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'options'=>array('class'=>'table table-striped table-lilac'),
            'filterModel' => $searchModel,
            'columns' => [ 
                [
                    'label' => 'Procedencia',
                    'attribute' => 'descripcion',
                ],
                'telefono',
                'domicilio',
                'mail',
                [
                    'label' => 'Localidad',
                    'attribute' => 'Localidad_id',
                    'value' => 'localidadTexto',
                    'filter' => Html::activeDropDownList($searchModel, 'Localidad_id', ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre'),['class'=>'form-control','prompt' => 'Localidad...']),
                   
                ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{edit}{delete}',
            'buttons' => [

            //view button
            'view' => function ($url, $model) {
           
                return Html::a('<span class="fa fa-eye activity-view-link"></span>', $url, [
                            'title' => Yii::t('app', 'Ver'),
                            'class'=>'btn btn-success btn-xs',
                           // 'value'=> "$url",
                ])." ";
            },
            'edit' => function ($url, $model) {
                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Editar'),
                            'class'=>'btn btn-info btn-xs',
                          //  'value'=> "$url",
                ])." ";
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
                $url ='index.php?r=procedencia/view&id='.$model['id'];
                return $url;
                     }
           if ($action === 'edit') {
               $url ='index.php?r=procedencia/update&id='.$model['id'];
               return $url;
              }
            if ($action === 'delete') {
               $url ='index.php?r=procedencia/delete&id='.$model['id'];
                return $url;
              }
        }
        ],
             ],
        ]); ?>

    <?php
    
$this->registerJsFile('@web/assets/admin/js/cipat_modal_procedencia.js', ['depends' => [yii\web\AssetBundle::className()]]);
     Pjax::end(); ?>
