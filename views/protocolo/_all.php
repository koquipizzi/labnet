<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use jino5577\daterangepicker\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Todos los Protocolos');
$this->params['breadcrumbs'][] = $this->title;
?>
        <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Todos los Protocolos y sus Estudios</h3>
                
            
            </div>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['protocolo/protocolo'], ['class'=>'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-star"></i> Asignados a mí', ['protocolo/asignados'], ['class'=>'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-pause-circle"></i> Pendientes', ['protocolo/'], ['class'=>'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-stop-circle"></i> Terminados', ['protocolo/terminados'], ['class'=>'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-check"></i> Entregados', ['protocolo/entregados'], ['class'=>'btn btn-primary']) ?>
                </div>
                <div class="clearfix"></div>
        </div>

        <div style="margin-top: 10px;">
            <?php
            echo GridView::widget([
            'dataProvider' => $dataProviderTodosLosProtocolos,
            'options'=>array('class'=>'table table-striped'),
            'filterModel' => $searchModel,
            'columns' => 
                [
                    [
                    'label' => 'Entrada',
                    'attribute' => 'fecha_entrada',
                    'contentOptions' => ['style' => 'width:7%;'],
                    'format' => ['date', 'php:d/m/Y'],

                    'filter' => DateRangePicker::widget([
                        'template' => '
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    {input}
                                </div>
                            ',
                        'model' => $searchModel,
                        'locale'    => 'es-ES',
                        'attribute' => 'fecha_entrada',
                        'pluginOptions' => [ 'format' => 'dd-mm-yyyy',
                        'locale'=>[
                            'format'=>'DD/MM/YYYY',
                            'separator'=>' - ',
                            'applyLabel' => 'Seleccionar',
                            'cancelLabel' => 'Cancelar',
                        ],
                        'autoUpdateInput' => false,
                        ]
                    ])
                ],
            [
                'label' => 'Nro Protocolo',
                'attribute' => 'codigo',
                'contentOptions' => ['style' => 'width:9%;'],
            ],
            [
                'label' => 'Paciente',
                'attribute'=>'nombre',
                'contentOptions' => ['style' => 'width:20%;'],
            ],
            [
                'attribute'=>'nro_documento',
                'contentOptions' => ['style' => 'width:5%;'],
            ],
            [
                'label' => 'Medico',
                'attribute'=>'medico_nombre',
                'contentOptions' => ['style' => 'width:20%;'],
            ], 
            [
                'label' => 'Cobertura',
                'attribute'=>'prestadoras_descripcion',
                'contentOptions' => ['style' => 'width:13%;'],
            ], 
            [
                'label' => 'Procedencia',
                'attribute'=>'procedencia_descripcion',
                'contentOptions' => ['style' => 'width:13%;'],
            ],            

            [
                'label' => 'Informes',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:10%;'],
                'value'=>function ($model, $key, $index, $widget) {
                            $estados = array(
                                                "1" => "danger",
                                                "2" => "default",
                                                "3" => "success",
                                                "4" => "warning",
                                                "5" => "primary",
                                                "6" => "info",
                                                );
                            $estadosLeyenda = array(
                                "1" => "INFORME PENDIENTE",
                                "2" => "INFORME DESCARTADO",
                                "3" => "EN PROCESO",
                                "4" => "INFORME PAUSADO",
                                "5" => "FINALIZADO",
                                "6" => "ENTREGADO",
                            );
                            $val = " ";
                            $idProtocolo = $model['id'];
                            $informes = app\models\Informe::find()->where(['=','Informe.Protocolo_id',$idProtocolo])->all();
                            //var_dump($model['id']); die();
                            foreach ($informes as $inf){
                            //   var_dump($inf);
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
                                $val = $val."<br /><span></span>";
                            }
                            return $val;
                        },
            ],            
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{edit}',
                'contentOptions' => ['style' => 'width:3%;'],
                'buttons' => [
                    //view button
                    'edit' => function ($url, $model) {                        
                        // $estadoInforme = \app\models\Workflow::find()->where(['informe_id' => $model['id']])->orderBy('fecha_inicio DESC')->one();
                        // if (!empty($estadoInforme)){
                        //     if ($estadoInforme->Estado_id == \app\models\Workflow::estadoFinalizado() || $estadoInforme->Estado_id == \app\models\Workflow::estadoEntregado()){
                        //         return null;
                        //     }
                        // }
                        return Html::a('<span class="fa fa-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'edit'),  
                                    'class'=> 'btn-info btn-xs',

                        ]);
                    },
                ],                
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'edit') {
                        $url ='index.php?r=protocolo/update&id='.$model['id'];
                        return $url;
                    }
                }
            ]
        ],

        ]);
        ?>
     </div>







<style>
    .summary{
        float:left;
    }

</style>
