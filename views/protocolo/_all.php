<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Todos los Protocolos');
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Protocolos Terminados</h3>
                 <i class="fa fa-stop"></i>                   
                <span class="text-strong"> Informes</span>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['paciente/'], ['class'=>'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-pause-circle"></i> Protocolos Pendientes', ['protocolo/'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-stop-circle"></i> Protocolos Terminados', ['protocolo/terminados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-list"></i> Protocolos Todos', ['protocolo/all'], ['class'=>'btn btn-primary']) ?>
            </div> 
            <div class="clearfix"></div>
        </div>

                                    <div style="margin-top: 30px;">
                                     <?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                    <?php                                      
                                    echo GridView::widget([
                                    'dataProvider' => $dataProviderTodosLosProtocolos,
                                    'options'=>array('class'=>'table table-striped table-lilac'),
                                    'filterModel' => $searchModel,        
                                    'columns' => [
                                         [
                                            'label' => 'Fecha Entrada',
                                            'attribute' => 'fecha_entrada',
                                            'contentOptions' => ['style' => 'width:15%;'],
                                            'format' => ['date', 'php:d/m/Y'],
                                            'filter' => DatePicker::widget([
                                                    'model' => $searchModel,
                                                    'attribute' => 'fecha_entrada',
                                                    'pluginOptions' => [
                                                        'autoclose'=>true,
                                                        'format' => 'dd-mm-yyyy',
                                                        'startView' => 'date',
                                                    ]
                                            ] )
                                        ],
                                        [
                                            'label' => 'Fecha Entrega',
                                            'contentOptions' => ['style' => 'width:15%;'],
                                            'attribute' => 'fecha_entrega',
                                            'format' => ['date', 'php:d/m/Y'],
                                            'filter' => DatePicker::widget([
                                                    'model' => $searchModel,
                                                    'attribute' => 'fecha_entrega',
                                                    'pluginOptions' => [
                                                        'autoclose'=>true,
                                                        'format' => 'dd-mm-yyyy',
                                                        'startView' => 'date',
                                                    ]
                                            ] )
                                        ],
                                       
                                        [
                                                    'label' => 'Protocolo',
                                                    'attribute' => 'codigo',
                                                    'contentOptions' => ['style' => 'width:10%;'],
                                        ],                                        
                                        [
                                            'label' => 'Paciente',
                                            'attribute'=>'nombre', 
                                            'contentOptions' => ['style' => 'width:30%;'],
                                        ],
                                        [
                                            'label' => 'Documento',
                                            'attribute'=>'nro_documento', 
                                            'contentOptions' => ['style' => 'width:10%;'],
                                        ],
//                                        [
//                                                'label'=>'Fecha de Entrega',
//                                                'attribute'=>'fecha_entrega', 
//                                                'format'=>['date','php:d-m-y'],
//                                                'contentOptions' => ['style' => 'width:15%;'],
//                                        ],
//                                        [
//                                                'label'=>'Avance',                    
//                                                'format'=>'raw',                    
//                                                'value'=>function ($model, $key, $index, $widget) { 
//                                                    $entero = date_diff(date_create($model->fecha_entrada),date_create($model->fecha_entrega));
//                                                    $parte = date_diff(date_create($model->fecha_entrada),new DateTime("now"));
//                                                    return '<span class="pie">'.$parte->format('%a').'/'.$entero->format('%a').'</span> ';                    
//                                                },               
//                                        ],

                                        [ 
                                            'label' => 'Informes',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width:20%;'],
                                            'value'=>function ($model, $key, $index, $widget) { 
                                                $estados = array( 
                                                    "1" => "danger", 
                                                    "2" => "inverse", 
                                                    "3" => "success",
                                                    "4" => "warning", 
                                                    "5" => "primary", 
                                                    "6" => "lilac",
                                                );
                                                $val = "";
                                                $idProtocolo = $model['id'];
                                                $informes = app\models\Informe::find()->where(['=','Informe.Protocolo_id',$idProtocolo])->all();
                                                //var_dump($model['id']); die();
                                                foreach ($informes as $inf){
                                                   // $val = $val.$inf->estudio->nombre." "; 
                                                    $estado = $inf->workflowLastState; 
                                                    $clase = " label-default";
//                                                    if ($estado == 4)
//                                                        $clase = " label-success";
//                                                    else {
//                                                    if ($estado == 1)
//                                                        $clase = " label-danger";
//                                                    else $clase = " label-info";                    
//                                                    }

                                                    $url ='index.php?r=informe/update&id='.$inf->id;
                                                    $val = $val. Html::a(Html::encode($inf->estudio->nombre),$url,[
                                                            'title' => Yii::t('app', 'Editar'),
                                                            'class'=>'label '. $clase.' rounded protoClass2', 
                                                            'value'=> "$url",       
                                                            'data-id'=> "$inf->id",  
                                                            'data-protocolo'=> "$inf->Protocolo_id",  
                                                ]);
                                                $val = $val."<br/><span></span>";}
                                                return $val;
                                            },
                                        ],                 

//                                                 [ 
//                                            'label' => '',
//                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width:20%;'],
//                                            'value'=>function ($model, $key, $index, $widget) { 
//                            //                    $val = "";
//                            //                    foreach ($model->informes as $inf){
//                            //                       // $val = $val.$inf->estudio->nombre." "; 
//                            //                        $estado = $inf->workflowLastState;
//                            //                        if ($estado == 4)
//                            //                            $clase = " label-success";
//                            //                        else {
//                            //                        if ($estado == 1)
//                            //                            $clase = " label-danger";
//                            //                        else $clase = " label-info";                    
//                            //                        }
//
//                                                    $url ='index.php?r=protocolo/view&id=';//.$model->id;
//                                                    $val = Html::a('<span class="glyphicon glyphicon-eye-open" style="width:30px;"></span>',$url,[
//                                                            'title' => Yii::t('app', 'Ver'),
//                                                            'class'=>'', 
//                                                            'value'=> "$url",       
//
//                                                         //   'data-protocolo'=> "$model->id",  
//                                                ]);
//                                            //    $val = $url;
//                                                 return $val;
//
//
//                                        },
//                                        ],  
                                     ],         

                                ]); 
                                    ?>
                                    <?php Pjax::end(); ?>   
                                    </div>
                                
                          
    
    
    


<style>
    .summary{
        float:left;
    }

</style>

























