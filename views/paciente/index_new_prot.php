<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use xj\bootbox\BootboxAsset;
BootboxAsset::register($this);

$this->title = Yii::t('app', 'Pacientes');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
    Modal::begin([
            'id' => 'modal',    
           // 'size'=>'modal-lg',
            'options' => ['tabindex' => false ],
        ]);
        echo "<div id='modalContent'></div>";
    Modal::end();  

    
    ?>
    <div>

</div>

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
<?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped'),
        'filterModel' => $searchModel,
        'columns' => [
        //    ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:5%;'],
                'value'=>function ($data) { 
                    if (isset($data['nombre_prest_nro']))
                        $nro= 'Cobertura: '.$data['nombre_prest_nro'];
                    else $nro= 'Cobertura: Sin datos';
                    $url ='index.php?r=paciente/view_modal&id='.$data['PacienteId'];
                    return Html::a('<i class="fa fa-arrow-right"></i>', FALSE, [
                                'title' => Yii::t('app', 'View'),
                                'class'=>'btn  btn-xs ver', 
                                'value'=> "$url",
                                'data-nro' => "$nro"
                    ]);;
                }
            ],
            [
                    'label' => 'Paciente',
                    'attribute'=>'nombre', 
                    'contentOptions' => ['style' => 'width:25%;'],
            ],
            [
                'label' => 'Nro Documento',
                'attribute'=>'nro_documento',
                'contentOptions' => ['style' => 'width:10%;'],
            ],
            [
                'label' => 'Teléfono',
                'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'width:10%;'],
                'attribute' => 'telefono',
            ],            
           // 'domicilio',
            [
                'label' => 'Cobertura/OS - Nro Afiliado',
                'attribute' => 'nombre_prest_nro',
                'contentOptions' => ['style' => 'width:30%;'],
                
            ], 
            [
            'class' => 'yii\grid\DataColumn', 
            'format' => 'raw',
            'value' => function ($data) {
              $url ='index.php?r=protocolo/create3&pacprest='.$data['pacprest'];
              $url2 ='index.php?r=paciente/view_modal&id='.$data['PacienteId'];
              return Html::a('<i class="fa fa-file"></i> Crear Protocolo', $url, [
                                'title' => Yii::t('app', 'View'),
                                'class'=>'btn btn-success btn-xs', 
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

