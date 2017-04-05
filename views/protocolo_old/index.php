<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
//use yii\helpers\ArrayHelper;
//use app\models\Estudio;
//use kartik\rating;
//use kartik\grid\GridView;
//use kartik\grid\EditableColumn;
//use common\components\GridViewEditable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProtocoloSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Protocolos');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
  //  $this->registerJsFile('@web/assets/global/plugins/bower_components/peity/jquery.peity.min.js', ['depends' => [yii\web\AssetBundle::className()]]);
//    $this->registerJsFile('@web/assets/admin/css/components/rating.css', ['depends' => [yii\web\AssetBundle::className()]]);
    
    ?>

    <div class="body-content animated fadeIn" >    
    <div class="protocolo-index">    
        <div class="panel_titulo">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="pull-right">
                    <?= Html::button('Nuevo Protocolo', ['value' => Url::to(['protocolo/create']), 'title' => 'Nuevo Protocolo', 'class' => 'loadMainContentProtocolo btn btn-success btn-sm']); ?>
                </div>   
                <div class="clearfix"></div>
            </div>
        </div>
   
         <div class="row">
            <div class="col-md-12">

                <!-- Start double tabs -->
                <div class="panel panel-tab panel-tab-double rounded shadow">
                    <!-- Start tabs heading -->
                    <div class="panel-heading no-padding">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab2-1" data-toggle="tab">
                                    <i class="fa fa-tasks"></i>
                                    <div>
                                        <span class="text-strong">Pendientes</span>
                                        <span>Protocolos Pendientes</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2-3" data-toggle="tab">
                                    <i class="fa fa-user"></i>
                                    <div>
                                        <span class="text-strong">Asignados a mí</span>
                                        <span>Informes asignados a mi usuario</span>
                                    </div>
                                </a>
                            </li>  
                            <li>
                                <a href="#tab2-4" data-toggle="tab">
                                    <i class="fa fa-sign-out"></i>
                                    <div>
                                        <span class="text-strong">Informes Finalizados</span>
                                        <span>en protocolos compuestos</span>
                                    </div>
                                </a>
                            </li>
<!--                            <li>
                                <a href="#tab2-5" data-toggle="tab">
                                    <i class="fa fa-user"></i>
                                    <div>
                                        <span class="text-strong">Protocolos Entregados</span>
                                        <span>Impresos, por mail, por web</span>
                                    </div>
                                </a>
                            </li>-->

                        </ul>
                    </div><!-- /.panel-heading -->
                    <!--/ End tabs heading -->

                    <!-- Start tabs content -->
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab2-1">
                                <h4 style="clear:both;">Protocolos Pendientes</h4>
                                <p>
                                <div style="margin-top: 30px;">
                                <?php Pjax::begin(['id' => 'pendientes']) ?> 
                                <?php  
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'options'=>array('class'=>'table table-striped table-lilac'),
                                    'filterModel' => $searchModel,   
                                    'columns' => [//'id', 
                                         [
                                            'label' => 'Fecha Entrada',
                                            'attribute' => 'fecha_entrada',
                                             'value' => 'fecha_entrada',
                                            'contentOptions' => ['style' => 'width:10%;'],
                                            'format' => ['date', 'php:d/m/Y'],
                                            'filter' => \yii\jui\DatePicker::widget([
                                                'model'=>$searchModel,
                                                'attribute'=>'fecha_entrada',
                                                'language' => 'es',
                                                'dateFormat' => 'dd/MM/yyyy',
                                            ]),
                                             
                                        ],
                                        [
                                            'label' => 'Fecha Entrega',
                                            'attribute' => 'fecha_entrega',
                                            'contentOptions' => ['style' => 'width:10%;'],
                                            'format' => ['date', 'php:d/m/Y'],
                                            'filter' => \yii\jui\DatePicker::widget([
                                                'model'=>$searchModel,
                                                'attribute'=>'fecha_entrega',
                                                'language' => 'es',
                                                'dateFormat' => 'dd/MM/yyyy',
                                            ]),
                                        ],
                                        [
                                            'label' => 'Nro Protocolo',
                                            'attribute' => 'codigo',
                                            'contentOptions' => ['style' => 'width:20%;'],
                                        ],                                          
                                                        
                                        [
                                            'label' => 'Paciente',
                                            'attribute'=>'nombre', 
                                            'contentOptions' => ['style' => 'width:20%;'],
                                        ],
                                        [
                                            'label' => 'Documento',
                                            'attribute'=>'nro_documento', 
                                            'contentOptions' => ['style' => 'width:10%;'],
                                        ],                                                    
                                        [ 
                                            'label' => 'Informes',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width:30%;'],
                                            'value'=>function ($model, $key, $index, $widget) { 
                                                $estados = array( 
                                                    "1" => "danger", 
                                                    "2" => "inverse", 
                                                    "3" => "success",
                                                    "4" => "warning", 
                                                    "5" => "primary", 
                                                    "6" => "teal",
                                                );
                                                $estadosLeyenda = array( 
                                                    "1" => "INFORME PENDIENTE", 
                                                    "2" => "INFORME DESCARTADO", 
                                                    "3" => "EN PROCESO",
                                                    "4" => "INFORME PAUSADO", 
                                                    "5" => "FINALIZADO", 
                                                    "6" => "ENTREGADO",
                                                );
                                                $val = "";
                                                $idProtocolo = $model['id'];
                                                $informes = app\models\Informe::find()->where(['=','Informe.Protocolo_id',$idProtocolo])->all();
                                                //var_dump($model['id']); die();
                                                foreach ($informes as $inf){
                                                    var_dump($inf); die();
                                                    $estado = $inf->workflowLastState; 
                                                    $clase = " label-".$estados[$estado];
                                                    $url ='index.php?r=informe/update&id='.$inf->id;
                                                    $val = $val. Html::a(Html::encode($inf->estudio->nombre),$url,[
                                                            'title' => "$estadosLeyenda[$estado]",
                                                            'class'=>'label '. $clase.' rounded protoClass2', 
                                                            'value'=> "$url",       
                                                            'data-id'=> "$inf->id",  
                                                            'data-protocolo'=> "$inf->Protocolo_id",  
                                                ]);
                                                $val = $val."<span></span>";}
                                                return $val;
                                            },
                                        ],                   
                                     ],         
                                ]); 
                                ?>
                                <?php Pjax::end() ?>
                                      <?php 
                                        Pjax::begin(['id'=>'asignados','enablePushState'=>true]);
                                echo GridView::widget([
//                                    'id'=>'asignados',
                                    'dataProvider' => $dataProvider_asignados,
                                    'options'=>array('class'=>'table table-striped table-lilac'),
                                    'filterModel' => $searchModelAsig,  
//                                    'pjax'=>true,
//
//                                    'pjaxSettings'=>[
//                                        'id' => 'asignados',
//                                        'neverTimeout'=>true,
//                                        'beforeGrid'=>'My fancy content before.',
//                                        'afterGrid'=>'My fancy content after.',
//                                        'enablePushState' => TRUE,
//                                        'options'=> 
//                                    ],
                                    'columns' => [//'id', 
                                         [
                                            'label' => 'Fecha Entrada',
                                            'attribute' => 'fecha_entrada',
                                            'contentOptions' => ['style' => 'width:10%;'],
                                            'format' => ['date', 'php:d/m/Y']
                                        ],
                                        [
                                            'label' => 'Fecha Entrega',
                                            'attribute' => 'fecha_entrega',
                                            'contentOptions' => ['style' => 'width:10%;'],
                                            'format' => ['date', 'php:d/m/Y']
                                        ],
                                         [
                                            'label' => 'Nro Protocolo',
                                            'attribute' => 'codigo',
                                            'contentOptions' => ['style' => 'width:20%;'],
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
                                            'label' => 'Informes',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width:30%;'],
                                            'value'=>function ($model, $key, $index, $widget) { 
                                                $estados = array( 
                                                    "1" => "danger", 
                                                    "2" => "inverse", 
                                                    "3" => "success",
                                                    "4" => "warning", 
                                                    "5" => "primary", 
                                                    "6" => "teal",
                                                );
                                                $estadosLeyenda = array( 
                                                    "1" => "INFORME PENDIENTE", 
                                                    "2" => "INFORME DESCARTADO", 
                                                    "3" => "EN PROCESO",
                                                    "4" => "INFORME PAUSADO", 
                                                    "5" => "FINALIZADO", 
                                                    "6" => "ENTREGADO",
                                                );
                                                $val = "";
                                                $idProtocolo = $model['id'];
                                                $estado = $model['lastEstado']; 
                                                $clase = " label-".$estados[$estado];
                                                $informes = app\models\Informe::find()->where(['=','Informe.Protocolo_id',$idProtocolo])->all();
                                                //var_dump($model['id']); die();
                                                $url ='index.php?r=informe/update&id='.$model['informe_id'];
                                                $val = $val. Html::a(Html::encode($model['nombre_estudio']),$url,[
                                                            'title' => "$estadosLeyenda[$estado]",
                                                            'class'=>'label '. $clase.' rounded protoClass2', 
                                                            'value'=> "$url",       
                                                            'data-id'=> $model['informe_id'],  
                                                            'data-protocolo'=> $model['id'],  
                                                ]);
                                                $val = $val."<span></span>";
                                                return $val;//                                              
                                            },
                                        ],                  
                                     ],         

                                ]); 
                                ?>
                                <?php Pjax::end() ?>   
                                    
                                   
                                </div>  
                                 <?php //Pjax::end(); ?>
                            </p>       
                            </div>
                            <div class="tab-pane fade" id="tab2-3">
                                <h4>Estudios asignados a mi</h4>
                                <p>
                                    <div style="margin-top: 30px;">
                                        <?php 
                                        Pjax::begin(['id'=>'asignados','enablePushState'=>true]);
                                echo GridView::widget([
//                                    'id'=>'asignados',
                                    'dataProvider' => $dataProvider_asignados,
                                    'options'=>array('class'=>'table table-striped table-lilac'),
                                    'filterModel' => $searchModelAsig,  
//                                    'pjax'=>true,
//
//                                    'pjaxSettings'=>[
//                                        'id' => 'asignados',
//                                        'neverTimeout'=>true,
//                                        'beforeGrid'=>'My fancy content before.',
//                                        'afterGrid'=>'My fancy content after.',
//                                        'enablePushState' => TRUE,
//                                        'options'=> 
//                                    ],
                                    'columns' => [//'id', 
                                         [
                                            'label' => 'Fecha Entrada',
                                            'attribute' => 'fecha_entrada',
                                            'contentOptions' => ['style' => 'width:10%;'],
                                            'format' => ['date', 'php:d/m/Y']
                                        ],
                                        [
                                            'label' => 'Fecha Entrega',
                                            'attribute' => 'fecha_entrega',
                                            'contentOptions' => ['style' => 'width:10%;'],
                                            'format' => ['date', 'php:d/m/Y']
                                        ],
                                         [
                                            'label' => 'Nro Protocolo',
                                            'attribute' => 'codigo',
                                            'contentOptions' => ['style' => 'width:20%;'],
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
                                            'label' => 'Informes',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width:30%;'],
                                            'value'=>function ($model, $key, $index, $widget) { 
                                                $estados = array( 
                                                    "1" => "danger", 
                                                    "2" => "inverse", 
                                                    "3" => "success",
                                                    "4" => "warning", 
                                                    "5" => "primary", 
                                                    "6" => "teal",
                                                );
                                                $estadosLeyenda = array( 
                                                    "1" => "INFORME PENDIENTE", 
                                                    "2" => "INFORME DESCARTADO", 
                                                    "3" => "EN PROCESO",
                                                    "4" => "INFORME PAUSADO", 
                                                    "5" => "FINALIZADO", 
                                                    "6" => "ENTREGADO",
                                                );
                                                $val = "";
                                                $idProtocolo = $model['id'];
                                                $estado = $model['lastEstado']; 
                                                $clase = " label-".$estados[$estado];
                                                $informes = app\models\Informe::find()->where(['=','Informe.Protocolo_id',$idProtocolo])->all();
                                                //var_dump($model['id']); die();
                                                $url ='index.php?r=informe/update&id='.$model['informe_id'];
                                                $val = $val. Html::a(Html::encode($model['nombre_estudio']),$url,[
                                                            'title' => "$estadosLeyenda[$estado]",
                                                            'class'=>'label '. $clase.' rounded protoClass2', 
                                                            'value'=> "$url",       
                                                            'data-id'=> $model['informe_id'],  
                                                            'data-protocolo'=> $model['id'],  
                                                ]);
                                                $val = $val."<span></span>";
                                                return $val;
//                                                foreach ($informes as $inf){
//                                                    $estado = $inf->workflowLastState; 
//                                                    $clase = " label-".$estados[$estado];
//                                                    $url ='index.php?r=informe/update&id='.$inf->id;
//                                                    $val = $val. Html::a(Html::encode($inf->estudio->nombre),$url,[
//                                                            'title' => "$estadosLeyenda[$estado]",
//                                                            'class'=>'label '. $clase.' rounded protoClass2', 
//                                                            'value'=> "$url",       
//                                                            'data-id'=> "$inf->id",  
//                                                            'data-protocolo'=> "$inf->Protocolo_id",  
//                                                ]);
//                                                $val = $val."<span></span>";}
//                                                return $val;
                                            },
                                        ],                  
                                     ],         

                                ]); 
                                ?>
                                <?php Pjax::end() ?>    
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="tab2-4">
                                <h4>Informes finalizados</h4>
                                <p>
                                    <div style="margin-top: 30px;">
                                     <?php //Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                     <?php
                                            echo GridView::widget([
                                            'dataProvider' => $dataProviderTerminados,
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
                                                ],
                                        ]); 
                                    ?>
                                    <?php //Pjax::end(); ?>   
                                    </div>
                                </p>
                            </div>
                            
                        </div>
                    </div><!-- /.panel-body -->
                    <!--/ End tabs content -->
                </div><!-- /.panel -->
                <!--/ End double tabs -->

            </div>
        </div><!-- /.row -->
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

<?php if (isset($_GET['new'])) 
    { 
    $this->registerJs(
            "$('#modal').find('.modal-header').html('Nuevo Protocolo');".
            "$('#modal').find('#modalContent').load('".Url::to(['protocolo/create'])."');".
            "$('#modal').modal('show');");
     } ?>

    
    



