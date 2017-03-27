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
        //    ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'nro_documento',
            [
                'label' => 'Teléfono',
                'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'width:12%;'],
                'attribute' => 'telefono',
            ],            
            'domicilio',
            [
                'label' => 'Cobertura/OS',
                'attribute' => 'nombre_prest',
            ], 
            [
            'class' => 'yii\grid\DataColumn', 
            'format' => 'raw',
            'value' => function ($data) {
              $url ='index.php?r=protocolo/protocolo&pacprest='.$data['pacprest'];
              return Html::a('<i class="fa fa-file"></i> Crear Protocolo', $url, [
                                'title' => Yii::t('app', 'View'),
                                'class'=>'btn  btn-xs ver', 
                                'value'=> "$url",
                    ]);
                },
            ],
         ],
    ]); ?>
<?php Pjax::end(); ?>


<?php 
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js',
    ['depends' => [yii\web\AssetBundle::className()]]);
?>

