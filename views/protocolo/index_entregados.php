<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use mdm\admin\components\Helper;
use jino5577\daterangepicker\DateRangePicker;

$this->title = Yii::t('app', 'Estudios');
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

    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/global/plugins/bower_components/peity/jquery.peity.min.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/admin/css/components/rating.css', ['depends' => [yii\web\AssetBundle::className()]]);

    ?>

    <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Estudios Entregados</h3>
            </div>
             <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['paciente/buscar'], ['class'=>'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-star"></i> Asignados a mí', ['protocolo/asignados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-pause-circle"></i> Pendientes', ['protocolo/'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-stop-circle"></i> Terminados', ['protocolo/terminados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-list"></i> Todos', ['protocolo/all'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>

            <!-- Start tabs content -->
            <div style="margin-top: 10px;">
                <?php
                $this->registerCss(".hasDatepicker {
                                    width:90px;}");
               // Pjax::begin(['id' => 'entregados']);
                echo GridView::widget([
//                                    'id'=>'asignados',
                    'dataProvider' => $dataProvider_entregados,
                     'options'=>array('class'=>'table table-striped table-lilac'),
                                            'filterModel' => $searchModel,
                                            'columns' =>    [
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
                                                        'pluginOptions' => [
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
                                                        'pluginOptions' => [
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
                                                    'attribute'=>'ultimo_propietario',
                                                    'contentOptions' => ['style' => 'width:10%;'],
                                                ],                                                 
                                                [
                                                      'label' => 'Informes',
                                                      'format' => 'raw',
                                                      'contentOptions' => ['style' => 'width:30%;'],
                                                      'value' => function ($model, $key, $index, $widget) {
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
                                                        $val = "";
                                                        $idProtocolo = $model['id'];
                                                        $informe = app\models\Informe::findOne($model['informe_id']);
                                                        $estado = $informe->workflowLastState;
                                                        $clase = " label-" . $estados[$estado];
                                                        $informes = app\models\Informe::find()->where(['=', 'Informe.Protocolo_id', $idProtocolo])->all();
                                                        $url = 'index.php?r=informe/update&id=' . $model['informe_id'];
                                                        $val = $val . Html::a(Html::encode($model['nombre_estudio']), $url, [
                                                                    'title' => "$estadosLeyenda[$estado]",
                                                                    'class' => 'label ' . $clase . ' rounded protoClass2',
                                                                    'value' => "$url",
                                                                    'data-id' => $model['informe_id'],
                                                                    'data-protocolo' => $model['id'],
                                                        ]);
                                                        $val = $val . "<br /><span></span>";
                                                        return $val;
                                                    },
                                                  ],
                                                [
                                                    'label' => 'Acciones',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'width:20%;'],
                                                    'value'=> function ($model) {
                                                    //llevatr esto al metodo

                                                                $data = $model['informe_id'];
                                                                //urls acciones
                                                                $url ='index.php?r=informe/entregar&accion=mail&id='.$model['informe_id'];
                                                                $urlPrint ='index.php?r=informe/entregar&accion=print&estudio='.$model['Estudio_id'].'&id='.$model['informe_id'];
                                                                $urlPublicar ='index.php?r=informe/entregar&accion=publicar&id='.$model['informe_id'];
                                                                $urlVer ='index.php?r=informe/view&id='.$model['informe_id'];
                                                                $urlEditar ='index.php?r=informe/update&id='.$model['informe_id'];

                                                                return Html::a("<i class='fa fa-print'></i>",$urlPrint,[
                                                                    'title' => Yii::t('app', 'Descargar/imprimir'),
                                                                    'class'=>'btn btn-primary btn-xs',
                                                                    'value'=> "$urlPrint",
                                                                    'data-id'=> "$data",
                                                                    'data-protocolo'=> "$data",
                                                                    'target'=>'_blank',
                                                                    'data-pjax' => 0                                                                    
                                                                ])." ".Html::a("<i class='fa fa-envelope'></i>",$url,[
                                                                    'title' => Yii::t('app', 'Enviar por Mail'),
                                                                    'class'=>'btn btn-primary btn-xs finalizado ',
                                                                    'value'=> "$url",
                                                                    'data-id'=> "$data",
                                                                    'data-protocolo'=> "$data",
                                                                ])
                                                                . " ".Html::a("<i class='fa fa-cloud-upload'></i>",$urlPublicar,[
                                                                    'title' => Yii::t('app', 'Publicar en WEB'),
                                                                    'class'=>'btn btn-primary btn-xs ',
                                                                    'value'=> "$urlPublicar",
                                                                    'data-id'=> "$data",
                                                                    'data-protocolo'=> "$data",
                                                                ])
                                                                ." ". Html::a("<i class='fa fa-eye'></i>",$urlVer,[
                                                                    'title' => Yii::t('app', 'Ver'),
                                                                    'class'=>'btn btn-primary btn-xs ',
                                                                    'value'=> "$urlVer",
                                                                    'data-id'=> "$data",
                                                                    'data-protocolo'=> "$data",
                                                                ])
                                                                . " ".Html::a("<i class='fa fa-pencil'></i>",$urlEditar,[
                                                                    'title' => Yii::t('app', 'Editar'),
                                                                    'class'=>'btn btn-primary btn-xs',
                                                                    'value'=> "$urlEditar",
                                                                    'data-id'=> "$data",
                                                                    'data-protocolo'=> "$data",
                                                                ]);


                                                    },
                                                 ],
                                                     /*    ['class' => 'yii\grid\ActionColumn',
                                                        'template' => '{view}{edit}',
                                                        'buttons' => [

                                                        //view button

                                                        'view' => function ($url, $model) {
                                                        if(Helper::checkRoute(substr($url, 12, 12))){
                                                                    return Html::a('<span class="fa fa-eye "></span>', FALSE, [
                                                                                'title' => Yii::t('app', 'View'),
                                                                                'class'=>'btn btn-success ver btn-xs',
                                                                                'value'=> "$url",
                                                                    ]);
                                                            }

                                                        },
                                                         'edit' => function ($url, $model) {
                                                            if(Helper::checkRoute(substr($url, 12, 12))){
                                                                return Html::a('<span class="fa fa-pencil"></span>', FALSE, [
                                                                            'title' => Yii::t('app', 'Editar'),
                                                                            'class'=>'btn btn-info btn-xs editar',
                                                                            'value'=> "$url",
                                                                        ]);

                                                            }
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
                                                    ]   */

                                                ]
                                        ]);
                                    ?>
                <?php //Pjax::end() ?>

            </div>
            </p>
<style>
    .summary{
        float:left;
    }


</style>
