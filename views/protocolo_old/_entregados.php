

<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
    
   

$this->title = Yii::t('app', 'Todos los Protocolos');
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
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/global/plugins/bower_components/peity/jquery.peity.min.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/admin/css/components/rating.css', ['depends' => [yii\web\AssetBundle::className()]]);
    
  ?>
<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet</h2>   
    </div><!-- /.header-content -->
<div class="body-content animated fadeIn" >    
    <div class="medico-index">
        <div class="panel_titulo">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Entregados</h3>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
                                <p>
                                    <div style="margin-top: 30px;">
                                     <?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                     <?php
                                            echo GridView::widget([
                                            'dataProvider' => $dataProviderEntregados,
                                            'options'=>array('class'=>'table table-striped table-lilac'),
                                         //   'filterModel' => $searchModel,    
                                            'columns' =>    [
                                                 //   'value'=>'estudio',
                                                 [
                                                    'label' => 'Fecha Entrada',
                                                    'attribute' => 'fecha_entrada',
                                                    'contentOptions' => ['style' => 'width:10%;'],
                                                    'format' => ['date', 'php:d-m-y']
                                                ],
                                                 [
                                                    'label' => 'Fecha Entrega',
                                                    'attribute' => 'fecha_entrega',
                                                    'contentOptions' => ['style' => 'width:10%;'],
                                                    'format' => ['date', 'php:d-m-y']
                                                ],
                                                 [
                                                    'label' => 'Año Letra',
                                                    'contentOptions' => ['style' => 'width:8%;'],
                                                    'value'=> function ($data, $key, $index, $column) {
                                                         $secuencia = $data['anio']."-".$data['letra'];
                                                         return $secuencia;
                                                    }
                                                ], 
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
                                                    'label' => 'Documento',
                                                    'attribute'=>'nro_documento', 
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                ],
                                                [
                                                    'label' => 'Informe',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                    'value'=> function ($model) { 
                                                        return $model['nombre_estudio'];                                                        
                                                    }
                                                ],
                                                [ 
                                                    'label' => 'Acciones',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'width:30%;'],
//                                                    'value'=> function ($model) { 
//                                                                $estudio = array( 
//                                                                    "1" => "printpap", 
//                                                                    "2" => "printanatomo", 
//                                                                    "3" => "printmole",
//                                                                    "4" => "printcito", 
//                                                                    "5" => "printinf", 
//                                                                );
//                                                                $data = $model['informe_id'];
//                                                                $url ='index.php?r=informe/update&id='.$model['informe_id'];
//                                                               // if ($model['Estudio_id'] == 1)                                                                    
//                                                                    $urlPrint ='index.php?r=informe/'.$estudio[$model['Estudio_id']].'&id='.$model['informe_id'];
//                                                              //  else  $urlPrint ='index.php?r=informe/print&id='.$model['informe_id'];
//                                                                $urlPublicar ='index.php?r=informe/update&id='.$model['informe_id'];
//                                                                return Html::a("<i class='glyphicon glyphicon-print'></i>",$urlPrint,[
//                                                                    'title' => Yii::t('app', 'Descargar/imprimir'),
//                                                                    'class'=>'label label-teal rounded ', 
//                                                                    'value'=> "$urlPrint",       
//                                                                    'data-id'=> "$data",  
//                                                                    'data-protocolo'=> "$data",
//                                                                    'target'=>'_blank',
//                                                                ]). Html::a("<i class='glyphicon glyphicon-send'></i>",$url,[
//                                                                    'title' => Yii::t('app', 'Enviar por Mail'),
//                                                                    'class'=>'label label-teal rounded ', 
//                                                                    'value'=> "$url",       
//                                                                    'data-id'=> "$data",  
//                                                                    'data-protocolo'=> "$data",  
//                                                                ])
//                                                                . Html::a("<i class='glyphicon glyphicon-cloud-upload'></i>",$url,[
//                                                                    'title' => Yii::t('app', 'Publicar en WEB'),
//                                                                    'class'=>'label label-teal rounded ', 
//                                                                    'value'=> "$urlPublicar",       
//                                                                    'data-id'=> "$data",  
//                                                                    'data-protocolo'=> "$data",  
//                                                                ]);
//                                                      
//                                                
//                                                    },
                                                    'value'=> function ($model) { 
                                                    //llevatr esto al metodo
                        
                                                                $data = $model['informe_id'];
                                                                //urls acciones
                                                                $url ='index.php?r=informe/entregar&accion=mail&id='.$model['informe_id'];                                                
                                                                $urlPrint ='index.php?r=informe/entregar&accion=print&estudio='.$model['Estudio_id'].'&id='.$model['informe_id'];
                                                                $urlPublicar ='index.php?r=informe/entregar&accion=publicar&id='.$model['informe_id'];
                                                                
                                                                return Html::a("<i class='glyphicon glyphicon-print'></i>",$urlPrint,[
                                                                    'title' => Yii::t('app', 'Descargar/imprimir'),
                                                                    'class'=>'label label-teal rounded ', 
                                                                    'value'=> "$urlPrint",       
                                                                    'data-id'=> "$data",  
                                                                    'data-protocolo'=> "$data",
                                                                    'target'=>'_blank',
                                                                ]). Html::a("<i class='glyphicon glyphicon-send'></i>",$url,[
                                                                    'title' => Yii::t('app', 'Enviar por Mail'),
                                                                    'class'=>'label label-teal rounded ', 
                                                                    'value'=> "$url",       
                                                                    'data-id'=> "$data",  
                                                                    'data-protocolo'=> "$data",  
                                                                ])
                                                                . Html::a("<i class='glyphicon glyphicon-cloud-upload'></i>",$url,[
                                                                    'title' => Yii::t('app', 'Publicar en WEB'),
                                                                    'class'=>'label label-teal rounded ', 
                                                                    'value'=> "$urlPublicar",       
                                                                    'data-id'=> "$data",  
                                                                    'data-protocolo'=> "$data",  
                                                                ]);
                                                      
                                                
                                                    },
                                                 ],       
                                                         
                                                         ['class' => 'yii\grid\ActionColumn',
                                                        'template' => '{view}{edit}',
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
                                                                        'class'=>'btn btn-info btn-xs editar',    
                                                                        'value'=> "$url",
                                                            ]);
                                                        },

                                                    ],
                                                    'urlCreator' => function ($action, $model, $key, $index) {
                                                        if ($action === 'view') {
                                                            $url ='index.php?r=informe/view&id='.$model['informe_id'];
                                                            return $url;
                                                            }
                                                        if ($action === 'edit') {
                                                            $url ='index.php?r=informe/update&id='.$model['informe_id'];
                                                            return $url;
                                                            }

                                                        }
                                                    ]
//                                                    function ($model, $key, $index, $widget) { 
//                                                        $val = "";
//                                                        foreach ($model->informes as $inf){
//                                                           // $val = $val.$inf->estudio->nombre." "; 
//                                                            $estado = $inf->workflowLastState;
//                                                            if ($estado == 4)
//                                                                $clase = " label-success";
//                                                            else {
//                                                            if ($estado == 1)
//                                                                $clase = " label-danger";
//                                                            else $clase = " label-info";                    
//                                                            }
//
//                                                            $url ='index.php?r=informe/update&id='.$inf->id;
//                                                            $val = $val. Html::a(Html::encode($inf->estudio->nombre),$url,[
//                                                                    'title' => Yii::t('app', 'Editar'),
//                                                                    'class'=>'label '. $clase.' rounded protoClass2', 
//                                                                    'value'=> "$url",       
//                                                                    'data-id'=> "$inf->id",  
//                                                                    'data-protocolo'=> "$model->id",  
//                                                        ]);
//                                                        $val = $val."<span></span>";}
//                                                        return $val;
//                                                    },
                                                
                                                ],

                                        ]); 
                                    ?>
                                    <?php Pjax::end(); ?>   
                                    </div>
                                </p>
                            </div>



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


































