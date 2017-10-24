<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\Prestadoras;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NomencladorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Nomencladors');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/assets/admin/js/cipat_modal_nomenclador.js');
?>


  <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Nomenclador', ['nomenclador/create'], ['class'=>'btn btn-primary']) ?>
            </div>   
            <div class="clearfix"></div>
        </div>

<?php Pjax::begin(['id' => 'nomenclador', 'enablePushState' => FALSE]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Código',
                'attribute'=>'servicio',
                'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'width:12%;'],
                'value' => function ($data, $url) { //var_dump($data); die();
                              return Html::a($data->servicio, FALSE, ['class' => 'editar', 'value'=>'index.php?r=nomenclador/update&id='.$data->id]);
                },
            ],
            'descripcion',
            'valor',
            'coseguro',
            [
                'attribute' => 'Prestadora',
                'value' => function ($model) {
                    return $model->getPrestadoraTexto();
                },
                'filter' => Html::activeDropDownList($searchModel, 'Prestadoras_id', ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion'),['class'=>'form-control','prompt' => 'Select Category']),
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {edit} {delete}',
            'contentOptions' =>['class' => 'table_class','style'=>'width:15%;'],
            'buttons' => [
            //view button
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-eye "></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-success ver btn-xs',
                            'value'=> "$url",
                ]);
            },
             'edit' => function ($url, $model) {
                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Editar'),
                            'class'=>'btn btn-info btn-xs editar',
                            'value'=> "$url",
                ]);
            },
             'delete' => function ($url, $model) {
                return Html::a('<span class="fa fa-trash"></span>', $url , [
                            'title' => Yii::t('app', 'Borrar'),
                            'class'=>'btn btn-danger btn-xs borrar',
                            'value'=> "$url",
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=nomenclador/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=nomenclador/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=nomenclador/delete&id='.$model->id;
                return $url;
                }
            }
        ],
         ],
        'rowOptions'=>function ($model, $key, $index, $grid){
                $class=$index%2?'odd':'even';
                return array('key'=>$key,'index'=>$index,'class'=>$class);
            },
    ]); ?>
<?php Pjax::end(); ?>

