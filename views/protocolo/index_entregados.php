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
    
    $js = <<<JS

            $('.sendMail').on('click',function() {
                var ajaxurl = $(this).attr('value');
                var n = noty({
                                    text: 'Se esta procesando el envio de mail',
                                    type: 'success',
                                    class: 'animated pulse',
                                    layout: 'topRight',
                                    theme: 'relax',
                                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                                    force: false, // adds notification to the beginning of queue when set to true
                                    modal: false, // si pongo true me hace el efecto de pantalla gris
                                    killer : true,
                });
                
                $.get( ajaxurl , function( data ) {
                   
                    if (data.rta == 'ok'){
                            var n = noty({
                                    text: data.message,
                                    type: 'success',
                                    class: 'animated pulse',
                                    layout: 'topRight',
                                    theme: 'relax',
                                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                                    force: false, // adds notification to the beginning of queue when set to true
                                    modal: false, // si pongo true me hace el efecto de pantalla gris
                                    killer : true,
                            });
                    }else{
                          var n = noty({
                                    text: data.message,
                                    type: 'success',
                                    class: 'animated pulse',
                                    layout: 'topRight',
                                    theme: 'relax',
                                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                                    force: false, // adds notification to the beginning of queue when set to true
                                    modal: false, // si pongo true me hace el efecto de pantalla gris
                                    killer : true,
                            });
                    }
                });
            });
JS;

    $this->registerJs($js);
    
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
                 <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['protocolo/protocolo'], ['class'=>'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-star"></i> Asignados a mí', ['protocolo/asignados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-pause-circle"></i> Pendientes', ['protocolo/'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-stop-circle"></i> Terminados', ['protocolo/terminados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-list"></i> Todos', ['protocolo/all'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>
            <div style="margin-top: 10px;">
                <?php
                $this->registerCss(".hasDatepicker {width:90px;}");
                echo GridView::widget([
                     'dataProvider' => $dataProvider_entregados,
                     'options'=>array('class'=>'table table-striped table-lilac'),
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'label' => 'Entrada',
                                'attribute' => 'fecha_entrada',
                                'contentOptions' => ['style' => 'width:8%;'],
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
                                'label' => 'Nro Protocolo',
                                'attribute' => 'codigo',
                                'contentOptions' => ['style' => 'width:11%;'],
                            ],
                            [
                                'label' => 'Paciente',
                                'attribute'=>'nombre',
                                'contentOptions' => ['style' => 'width:24%;'],
                                /*'value'=>function ($model, $key, $index, $widget) {
                                    if(strlen($model["nombre"])>20){
                                        return substr($model["nombre"], 0, 14)."...";
                                    }  else {
                                           return $model["nombre"];
                                    }
                                }*/
                            ],
                            [
                                'attribute'=>'nro_documento',
                                'contentOptions' => ['style' => 'width:6%;'],
                            ],
                            [
                                'label' => 'Medico',
                                'attribute'=>'nombre_medico',
                                'contentOptions' => ['style' => 'width:25%;'],
                            ],
                            [
                                'label' => 'Informes',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width:10%;'],
                                'value' => function ($model, $key, $index, $widget) {
                                    $estados = ["1" => "danger", "2" => "default", "3" => "success", "4" => "warning", "5" => "primary", "6" => "info"];
                                    $estadosLeyenda =[
                                                        "1" => "INFORME PENDIENTE",
                                                        "2" => "INFORME DESCARTADO",
                                                        "3" => "EN PROCESO",
                                                        "4" => "INFORME PAUSADO",
                                                        "5" => "FINALIZADO",
                                                        "6" => "ENTREGADO",
                                                    ];
                                    $val = "";
                                    $idProtocolo = $model['id'];
                                    $informe = app\models\Informe::findOne($model['informe_id']);
                                    $estado = $informe->workflowLastState;
                                    $clase = " label-" . $estados[$estado];
                                    $informes = app\models\Informe::find()->where(['=', 'Informe.Protocolo_id', $idProtocolo])->all();
                                    $url = Url::to(['informe/update', 'id' => $model['informe_id']]);
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
                                'contentOptions' => ['style' => 'width:18%;'],
                                'value'=> function ($model) {
                                    $dataEstudio = $model['Estudio_id'];
                                    $data = $model['informe_id'];
                                    //urls acciones
                                    $url            = Url::to(['informe/entregar', 'accion' => 'mail', 'id' => $data]);
                                    $urlPrint       = Url::to(['informe/entregar', 'accion' => 'print','estudio'=>$dataEstudio, 'id' => $data]);
                                    $urlPublicar    = Url::to(['informe/entregar', 'accion' => 'publicar', 'id' => $data]);
                                    $urlVer         = Url::to(['informe/view',  'id' => $data]);
                                    $urlEditar      = Url::to(['informe/update', 'id' => $data]);
                                    
                                    return Html::a("<i class='fa fa-print'></i>",$urlPrint,[
                                        'title' => Yii::t('app', 'Descargar/imprimir'),
                                        'class'=>'btn btn-primary btn-xs',
                                        'value'=> "$urlPrint",
                                        'data-id'=> "$data",
                                        'data-protocolo'=> "$data",
                                        'target'=>'_blank',
                                        'data-pjax' => 0
                                    ])." ".Html::a("<i class='fa fa-envelope '></i>",null,[
                                        'title' => Yii::t('app', 'Enviar por Mail'),
                                        'class'=>'btn btn-primary btn-xs finalizado sendMail ',
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
                        ]
                     ]);
                ?>
            </div>
            </p>
<style>
    .summary{
        float:left;
    }


</style>
