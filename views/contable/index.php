<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EstudioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estudios');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    Modal::begin([
            'id' => 'modal',          
            'options' => ['tabindex' => false ],  
         //   'clientOptions' => ['backdrop' => false],
        ]);
        echo "<div id='modalContent'>"
    . "<!--img class='mr-15' src='@web/assets/global/img/loader/general/3.gif' -->"
                . "</div>";
       
            

        
?> 
<?php Modal::end(); ?>

  <?php 
  use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_contable.js', ['depends' => [yii\web\AssetBundle::className()]]);
     ?>


<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
<div class="body-content animated fadeIn" >    
<div class="estudio-index">
    
    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="float:right;">
        <?= Html::a(Yii::t('app', 'Nuevo Pago'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
<?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                     <?php
                                            echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'options'=>array('class'=>'table table-striped table-lilac'),
                                         //   'filterModel' => $searchModel,    
                                            'columns' =>    [
                                                 //   'value'=>'estudio',


                                                [
                                                    'label' => 'Protocolo',
                                                    'value'=> function ($data, $key, $index, $column) {
                                                         $secuencia = sprintf("%06d", $data['nro_secuencia']);
                                                         return $secuencia;
                                                    },
                                                    'contentOptions' => ['style' => 'width:15%;'],
                                                ],      
                                                [
                                                    'label' => 'Paciente',
                                                    'attribute'=>'nombre', 
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                ],
                                                 [
                                                       'label' => 'Facturar A',   
                                                       'value'=> function ($model) { 
                                                        $id_facturar= $model['FacturarA_id'];            
                                                        $facturante=app\models\Prestadoras::find()->where(["id"=>$id_facturar])->one();
                                                       return $facturante->descripcion;
                                                    }
                                                ],             
                                                [
                                                    'label' => 'Informe',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                    'value'=> function ($model) { 
                                                        return $model['nombre_estudio'];                                                        
                                                    }
                                                ], 
                                                
                                                                                                   
                                                       
                                                         
                                                    ['class' => 'yii\grid\ActionColumn',
                                                        'template' => '{edit}',
                                                        'buttons' => [

//                                                        //view button
//                                                        'view' => function ($url, $model) {
//                                                            return Html::a('<span class="fa fa-check "></span>', FALSE, [
//                                                                        'title' => Yii::t('app', 'View'),
//                                                                        'class'=>'btn btn-success ver btn-xs',    
//                                                                        'value'=> "$url",
//                                                            ]);
//                                                        },
                                                         'edit' => function ($url, $model) {
                                                            return Html::a('<span class="fa fa-pencil"></span>', FALSE, [
                                                                        'title' => Yii::t('app', 'Editar'),
                                                                        'class'=>'btn btn-info btn-xs editar',    
                                                                        'value'=> "$url",
                                                            ]);
                                                        },

                                                    ],
                                                    'urlCreator' => function ($action, $model, $key, $index) {
                                                        if ($action === 'view') {
                                                            $url ='index.php?r=contable/update&id='.$model['informe_id'];
                                                            return $url;
                                                            }
                                                        if ($action === 'edit') {
                                                            $url ='index.php?r=contable/update&id='.$model['informe_id'];
                                                            return $url;
                                                            }

                                                        }
                                                    ]
                                                
                                                ],

                                        ]); 
                                    ?>
                                    
<?php Pjax::end(); ?></div>
    </div>
</section>

<style>
    .summary{
        float:left;
    }

</style>
