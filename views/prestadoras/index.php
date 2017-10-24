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
use app\models\Informe;
use xj\bootbox\BootboxAsset;
BootboxAsset::register($this);


$this->title = Yii::t('app', 'Coberturas');
$this->params['breadcrumbs'][] = $this->title;
  ?>

    <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nueva Cobertura/OS', ['prestadoras/createprepaga'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>




    <?php Pjax::begin(['id' => 'prestadoras']);  ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'descripcion',
            [
                'attribute'=>'telefono',
                'contentOptions' => ['style' => 'width:10%;'],
            ],
            'email:email',
            'domicilio',
            [
                'label' => 'Localidad',
                'attribute' =>'Localidad_id',
                'value'=>function($data){
                             $localidad = Localidad::find('nombre')->andWhere(['id' => $data['Localidad_id']])->one();
                        //   var_dump($localidad);die();
                            return $localidad->nombre;
                },
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
                $url ='index.php?r=prestadoras/view&id='.$model['id'];
                return $url;
                     }
           if ($action === 'edit') {
               $url ='index.php?r=prestadoras/update&id='.$model['id'];
               return $url;
              }
            if ($action === 'delete') {
               $url ='index.php?r=prestadoras/delete&id='.$model['id'];
                return $url;
              }
        }
        ],
         ],
    ]); ?>


        <?php


    Pjax::end(); ?>


<style>
    .summary{
        float:left;
    }


</style>

<?php
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_prestadora.js',
    ['depends' => [yii\web\AssetBundle::className()]]);
?>
