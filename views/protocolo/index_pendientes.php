<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use kartik\widgets\DatePicker;
use jino5577\daterangepicker\DateRangePicker;

$this->title = Yii::t('app', 'Protocolos');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/global/plugins/bower_components/peity/jquery.peity.min.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/admin/css/components/rating.css', ['depends' => [yii\web\AssetBundle::className()]]);

    ?>
        <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Protocolos Pendientes</h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['paciente/buscar'], ['class'=>'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-star"></i> Asignados a mí', ['protocolo/asignados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-stop-circle"></i> Terminados', ['protocolo/terminados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-check"></i> Entregados', ['protocolo/entregados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-list"></i> Todos', ['protocolo/all'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>

            <!-- Start tabs content -->
            <div>
                <?php
                Pjax::begin(['id' => 'pendientes', 'enablePushState' => false]) ?>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options'=>array('class'=>'table table-striped'),
                    'filterModel' => $searchModel,
                    'columns' => [//'id',
                    [
                            'label' => 'Fecha Entrada',
                            'attribute' => 'fecha_entrada',
                            'contentOptions' => ['style' => 'width:20%;'],
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
                            'label' => 'Fecha de Entrega',
                            'attribute' => 'fecha_entrega',
                            'contentOptions' => ['style' => 'width:20%;'],
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
                                'attribute' => 'fecha_entrega',
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
                            'contentOptions' => ['style' => 'width:7%;'],
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
                            'attribute'=>'nro_documento',
                            'contentOptions' => ['style' => 'width:6%;'],
                        ],
                        [
                            'label' => 'Informes',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:30%;'],
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
                     ],
                ]);
                ?>
                <?php Pjax::end() ?>
            </div>
