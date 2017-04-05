<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\Estudio;
use kartik\rating;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use common\components\GridViewEditable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProtocoloSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Protocolos');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    Modal::begin([
            'id' => 'modal',    
           // 'size'=>'modal-lg',
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
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>  
    </div><!-- /.header-content -->
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
                            
                            <li>
                                <a href="#tab2-2" data-toggle="tab">
                                    <i class="fa fa-check-circle"></i>
                                    <div>
                                        <span class="text-strong">Protocolos</span>
                                        <span>Protocolos finalizados</span>
                                    </div>
                                </a>
                            </li>
                            
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
                                     <?php 
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'options'=>array('class'=>'table table-striped table-lilac'),
                                 //   'filterModel' => $searchModel,        
                                    'columns' => [
                                       // ['class' => 'yii\grid\SerialColumn'],
                                        [
                                            'attribute' => 'fecha_entrada',
                                            'contentOptions' => ['style' => 'width:10%;'],
                                            'format' => ['date', 'php:d-m-y']
                                        ],
                                        [
                                            'label' => 'Paciente',
                                            'attribute'=>'nombre', 
                                             'contentOptions' => ['style' => 'width:20%;'],
                                            'value'=>function ($model, $key, $index, $widget) { 
                                                if(strlen($model["nombre"])>17){
                                                    return substr($model["nombre"], 0, 14)."...";
                                                }  else {
                                                       return $model["nombre"];
                                                }
                                            }
                                        ],
                                        [
                                            'label' => 'Código',
                                            'attribute'=>'codigo', 
                                            'contentOptions' => ['style' => 'width:15%;'],
                                        ],
                                        [
                                                'label'=>'Fecha de Entrega',
                                                'attribute'=>'fecha_entrega', 
                                                'format'=>['date','php:d-m-y'],
                                                'contentOptions' => ['style' => 'width:15%;'],
                                        ],
                                        [
                                                'label'=>'Avance',                    
                                                'format'=>'raw',                    
                                                'value'=>function ($model, $key, $index, $widget) { 
                                                    $entero = date_diff(date_create($model->fecha_entrada),date_create($model->fecha_entrega));
                                                    $parte = date_diff(date_create($model->fecha_entrada),new DateTime("now"));
                                                    return '<span class="pie">'.$parte->format('%a').'/'.$entero->format('%a').'</span> ';                    
                                                },               
                                        ],

                                        [ 
                                            'label' => 'Informes',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width:30%;'],
                                            'value'=>function ($model, $key, $index, $widget) { 
                                                $val = "";
                                                foreach ($model->informes as $inf){
                                                   // $val = $val.$inf->estudio->nombre." "; 
                                                    $estado = $inf->workflowLastState;
                                                    if ($estado == 4)
                                                        $clase = " label-success";
                                                    else {
                                                    if ($estado == 1)
                                                        $clase = " label-danger";
                                                    else $clase = " label-info";                    
                                                    }

                                                    $url ='index.php?r=informe/update&id='.$inf->id;
                                                    $val = $val. Html::a(Html::encode($inf->estudio->nombre),$url,[
                                                            'title' => Yii::t('app', 'Editar'),
                                                            'class'=>'label '. $clase.' rounded protoClass2', 
                                                            'value'=> "$url",       
                                                            'data-id'=> "$inf->id",  
                                                            'data-protocolo'=> "$model->id",  
                                                ]);
                                                $val = $val."<span></span>";}
                                                return $val;
                                        },
                                        ],                 

                                                 [ 
                                            'label' => '',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width:20%;'],
                                            'value'=>function ($model, $key, $index, $widget) { 
                            //                    $val = "";
                            //                    foreach ($model->informes as $inf){
                            //                       // $val = $val.$inf->estudio->nombre." "; 
                            //                        $estado = $inf->workflowLastState;
                            //                        if ($estado == 4)
                            //                            $clase = " label-success";
                            //                        else {
                            //                        if ($estado == 1)
                            //                            $clase = " label-danger";
                            //                        else $clase = " label-info";                    
                            //                        }

                                                    $url ='index.php?r=protocolo/view&id='.$model->id;
                                                    $val = Html::a('<span class="glyphicon glyphicon-eye-open" style="width:30px;"></span>',$url,[
                                                            'title' => Yii::t('app', 'Ver'),
                                                            'class'=>'', 
                                                            'value'=> "$url",       

                                                            'data-protocolo'=> "$model->id",  
                                                ]);
                                            //    $val = $url;
                                                 return $val;


                                        },
                                        ],  
                                     ],         

                                ]); 
                                    ?>
                                
                                </div>       
                            </p>       
                            </div>
                            <div class="tab-pane fade" id="tab2-2">
                                <h4>Listado de protocolos trabajados</h4>
                                <p>
                                    <div style="margin-top: 30px;">
                                     <?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                      <?php 
                                            echo GridView::widget([
                                            'dataProvider' => $dataProvider2,
                                            'options'=>array('class'=>'table table-striped table-lilac'),
                                         //   'filterModel' => $searchModel,        
                                            'columns' => [
                                               // ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'attribute' => 'fecha_entrada',
                                                    'contentOptions' => ['style' => 'width:10%;'],
                                                    'format' => ['date', 'php:d-m-y']
                                                ],
                                                [
                                                    'label' => 'Paciente',
                                                    'attribute'=>'pacienteText', 
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                ],
                                                [
                                                    'label' => 'Código',
                                                    'attribute'=>'codigo', 
                                                    'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                                [
                                                        'label'=>'Fecha de Entrega',
                                                        'attribute'=>'fecha_entrega', 
                                                        'format'=>['date','php:d-m-y'],
                                                        'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                                [
                                                        'label'=>'Rsponsable',
                                                        'attribute'=>'Responsable_id',                                                
                                                        'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                             ],         

                                        ]); 
                                    ?>
                                    <?php Pjax::end(); ?>   
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="tab2-3">
                                <h4>Estudios asignados a mi</h4>
                                <p>
                                    <div style="margin-top: 30px;">
                                        <?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                        <?php
                                                    $gridColumns = [
            // ...
            [
              //  'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'fecha_entrada',
//                 	'editableOptions'=> function ($model, $key, $index) {
// 						return [
// 								'header'=>'Name',
// 								'size'=>'md',
// 								'inputType'=>\kartik\editable\Editable::INPUT_TEXTAREA
// 								
// 						];
//					},
              //  'attribute' => 'fecha_entrada',
//                                                    'contentOptions' => ['style' => 'width:10%;'],
//                                                   'format' => ['date', 'php:d-m-y']
            ],//
            // ...
        ];
                                        
                                            echo GridView::widget([
                                            'dataProvider' => $dataProvider_asignados,
                                            'options'=>array('class'=>'table table-striped table-lilac'),
                                         //   'filterModel' => $searchModel,    
                                            'columns' =>    [
                                                    'value'=>'estudio',
                                                  //  'contentOptions'=>['class'=>'editColumn']
                                                ],

//                                            'columns' => [
//                                               // ['class' => 'yii\grid\SerialColumn'],
//                                                [
//                                                    'attribute' => 'fecha_entrada',
//                                                    'contentOptions' => ['style' => 'width:10%;'],
//                                                    'format' => ['date', 'php:d-m-y']
//                                                ],
//                                                [
//                                                    'label' => 'Estudio',
//                                                    'attribute'=>'estudio', 
//                                                    'contentOptions' => ['style' => 'width:20%;'],
//                                                ],
//                                                [
//                                                    'label' => 'Código',
//                                                    'attribute'=>'codigo', 
//                                                    'contentOptions' => ['style' => 'width:15%;'],
//                                                ],
//                                                [
//                                                        'label'=>'Fecha de Entrega',
//                                                        'attribute'=>'fecha_entrega', 
//                                                        'format'=>['date','php:d-m-y'],
//                                                        'contentOptions' => ['style' => 'width:15%;'],
//                                                ],
//                                                [
//                                                        'label'=>'Rsponsable',
//                                                        'attribute'=>'Responsable_id',                                                
//                                                        'contentOptions' => ['style' => 'width:15%;'],
//                                                ],
//                                             ],         

                                        ]); 
                                    ?>
                                    <?php Pjax::end(); ?>   
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="tab2-4">
                                <h4>Informes terminados en Protocolos compuestos</h4>
                                <p>
                                    <div style="margin-top: 30px;">
                                     <?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                      <?php 
                                            echo GridView::widget([
                                            'dataProvider' => $dataProvider2,
                                            'options'=>array('class'=>'table table-striped table-lilac'),
                                         //   'filterModel' => $searchModel,        
                                            'columns' => [
                                               // ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'attribute' => 'fecha_entrada',
                                                    'contentOptions' => ['style' => 'width:10%;'],
                                                    'format' => ['date', 'php:d-m-y']
                                                ],
                                                [
                                                    'label' => 'Paciente',
                                                    'attribute'=>'pacienteText', 
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                ],
                                                [
                                                    'label' => 'Código',
                                                    'attribute'=>'codigo', 
                                                    'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                                [
                                                        'label'=>'Fecha de Entrega',
                                                        'attribute'=>'fecha_entrega', 
                                                        'format'=>['date','php:d-m-y'],
                                                        'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                                [
                                                        'label'=>'Rsponsable',
                                                        'attribute'=>'Responsable_id',                                                
                                                        'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                             ],         

                                        ]); 
                                    ?>
                                    <?php Pjax::end(); ?>   
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="tab2-5">
                                <h4>Protocolos Entregados</h4>
                                <p>
                                    <div style="margin-top: 30px;">
                                     <?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                      <?php 
                                            echo GridView::widget([
                                            'dataProvider' => $dataProvider2,
                                            'options'=>array('class'=>'table table-striped table-lilac'),
                                         //   'filterModel' => $searchModel,        
                                            'columns' => [
                                               // ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'attribute' => 'fecha_entrada',
                                                    'contentOptions' => ['style' => 'width:10%;'],
                                                    'format' => ['date', 'php:d-m-y']
                                                ],
                                                [
                                                    'label' => 'Paciente',
                                                    'attribute'=>'pacienteText', 
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                ],
                                                [
                                                    'label' => 'Código',
                                                    'attribute'=>'codigo', 
                                                    'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                                [
                                                        'label'=>'Fecha de Entrega',
                                                        'attribute'=>'fecha_entrega', 
                                                        'format'=>['date','php:d-m-y'],
                                                        'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                                [
                                                        'label'=>'Rsponsable',
                                                        'attribute'=>'Responsable_id',                                                
                                                        'contentOptions' => ['style' => 'width:15%;'],
                                                ],
                                             ],         

                                        ]); 
                                    ?>
                                    <?php Pjax::end(); ?>   
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
    
    <?php 
//    echo GridView::widget([
//        'dataProvider' => $dataProvider,
//        'options'=>array('class'=>'table table-striped table-lilac'),
//     //   'filterModel' => $searchModel,        
//        'columns' => [
//           // ['class' => 'yii\grid\SerialColumn'],
//            [
//                'attribute' => 'fecha_entrada',
//                'contentOptions' => ['style' => 'width:10%;'],
//                'format' => ['date', 'php:d-m-y']
//            ],
//            [
//                'label' => 'Paciente',
//                'attribute'=>'pacienteText', 
//                'contentOptions' => ['style' => 'width:20%;'],
//            ],
//            [
//                'label' => 'Código',
//                'attribute'=>'codigo', 
//                'contentOptions' => ['style' => 'width:15%;'],
//            ],
//            [
//                    'label'=>'Fecha de Entrega',
//                    'attribute'=>'fecha_entrega', 
//                    'format'=>['date','php:d-m-y'],
//                    'contentOptions' => ['style' => 'width:15%;'],
//            ],
//            [
//                    'label'=>'Avance',                    
//                    'format'=>'raw',                    
//                    'value'=>function ($model, $key, $index, $widget) { 
//                        $entero = date_diff(date_create($model->fecha_entrada),date_create($model->fecha_entrega));
//                        $parte = date_diff(date_create($model->fecha_entrada),new DateTime("now"));
//                        return '<span class="pie">'.$parte->format('%a').'/'.$entero->format('%a').'</span> ';                    
//                    },               
//            ],
//            
//            [ 
//                'label' => 'Informes',
//                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:30%;'],
//                'value'=>function ($model, $key, $index, $widget) { 
//                    $val = "";
//                    foreach ($model->informes as $inf){
//                       // $val = $val.$inf->estudio->nombre." "; 
//                        $estado = $inf->workflowLastState;
//                        if ($estado == 4)
//                            $clase = " label-success";
//                        else {
//                        if ($estado == 1)
//                            $clase = " label-danger";
//                        else $clase = " label-info";                    
//                        }
//
//                        $url ='index.php?r=informe/update&id='.$inf->id;
//                        $val = $val. Html::a(Html::encode($inf->estudio->nombre),$url,[
//                                'title' => Yii::t('app', 'Editar'),
//                                'class'=>'label '. $clase.' rounded protoClass2', 
//                                'value'=> "$url",       
//                                'data-id'=> "$inf->id",  
//                                'data-protocolo'=> "$model->id",  
//                    ]);
//                    $val = $val."<span></span>";}
//                    return $val;
//            },
//            ],                 
//
//                     [ 
//                'label' => '',
//                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:20%;'],
//                'value'=>function ($model, $key, $index, $widget) { 
////                    $val = "";
////                    foreach ($model->informes as $inf){
////                       // $val = $val.$inf->estudio->nombre." "; 
////                        $estado = $inf->workflowLastState;
////                        if ($estado == 4)
////                            $clase = " label-success";
////                        else {
////                        if ($estado == 1)
////                            $clase = " label-danger";
////                        else $clase = " label-info";                    
////                        }
//
//                        $url ='index.php?r=protocolo/view&id='.$model->id;
//                        $val = Html::a('<span class="glyphicon glyphicon-eye-open" style="width:30px;"></span>',$url,[
//                                'title' => Yii::t('app', 'Ver'),
//                                'class'=>'', 
//                                'value'=> "$url",       
//                         
//                                'data-protocolo'=> "$model->id",  
//                    ]);
//                //    $val = $url;
//                     return $val;
//                
//                     
//            },
//            ],  
//         ],         
//        
//    ]); 
        ?>
<?php // Pjax::end(); ?></div>
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

    
    



