<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Crear Protocolo - Seleccione Paciente');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
    Modal::begin([
            'id' => 'modal',          
            'options' => ['tabindex' => false ],  
         //   'clientOptions' => ['backdrop' => false],
        ]);
        echo "<div id='modalContent'></div>";
       
?> 
<?php Modal::end(); ?>

<?php 
    use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js', ['depends' => [yii\web\AssetBundle::className()]]);

?>

<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
<div class="body-content animated fadeIn" >    
<div class="paciente-index">  
    <div class="panel_titulo">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                
            </div>
            <div class="pull-right">
                <?= Html::button('Nuevo Paciente', ['value' => Url::to(['paciente/create']), 'title' => 'Nuevo Paciente', 'class' => 'loadMainContentPaciente btn btn-success btn-sm']); ?>
            </div>   
            <div class="clearfix"></div>
        </div>
    </div>

<?php Pjax::begin(['id'=>'pacientes', 'enablePushState' => FALSE]); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'nro_documento',
            [
                'label' => 'Teléfono',
                'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'width:12%;'],
                'attribute' => 'telefono',
            ],            
            'domicilio',
            

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
                            'title' => Yii::t('app', 'Editar'),
                            'class'=>'btn btn-info editar btn-xs', 
                            'value'=> "$url",       
                            'data-id'=> "$model->id",       
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
                $url ='index.php?r=paciente/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=paciente/chequear&id='.$model->id;
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
<?php Pjax::end(); ?></div>
    </div>
     <!-- Start footer content -->
    <?php echo $this->render('/shares/_footer_admin') ;?>
    <!--/ End footer content -->
</section>

