<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use xj\bootbox\BootboxAsset;
BootboxAsset::register($this);

$this->title = Yii::t('app', 'Pacientes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="header-content">
    <div class="pull-left">
        <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="pull-right">
        <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Paciente', ['paciente/create'], ['class'=>'btn btn-primary']) ?>
    </div> 
    <div class="clearfix"></div>
</div>

<?php Pjax::begin(['id'=>'pacientes', 'enablePushState' => FALSE]); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label'=>'Nombre',
                'attribute' => 'nombre',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->nombre, Url::to(['paciente/view', 'id'=>$data->id]), [
                        'title' => Yii::t('app', 'Ver información'),
                        'class'=>'',    
                    ]);
                },
            ],
            'nro_documento',
            [
                'label' => 'Teléfono',
                'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'width:12%;'],
                'attribute' => 'telefono',
            ],            
            'domicilio',
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {edit} {delete}',
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
                            'class'=>'btn btn-danger borrar btn-xs',   
                            'value'=>"$url",    
                ]);
            },        
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=paciente/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=paciente/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=paciente/delete&id='.$model->id;
                return $url;
                }
            }
        ],
        ],
    ]); ?>
<?php Pjax::end(); ?>


<?php 
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js',
    ['depends' => [yii\web\AssetBundle::className()]]);
?>

