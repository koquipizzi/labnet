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
    function sendNoty(message,type){
        return noty({
            text: message,
            type: type,
            class: 'animated pulse',
            layout: 'topRight',
            theme: 'relax',
            timeout: 3000, // delay for closing event. Set false for sticky notifications
            force: false, // adds notification to the beginning of queue when set to true
            modal: false, // si pongo true me hace el efecto de pantalla gris
            killer : true,
        });
    }

    function changeButtonColor(button,color)
    {
        button.css('background-color',color.main);
        button.css('border-color',color.border);
        button.children('.fa').css('color',color.fa);
    }
    
    $('.sendRequest').on('click',function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let id_estudio = $(this).attr('data-id');
        let myspinner =  $('#spinnerqw-'+id_estudio);
        myspinner.toggleClass('lds-circle');
        var button = $(this);
        var ajaxurl = $(this).attr('value');
        sendNoty($(this).attr('ajax-before-send'),'success');
        $.get( ajaxurl , function( data ) {
            if (data.rta == 'ok'){
                sendNoty(data.message,'success');
                changeButtonColor(button,{main:'#48f148',fa:'#1d641b',border:'#267426'})
                }
            else{
                sendNoty(data.message,'error');
                changeButtonColor(button,{main:'#f65353',fa:'#970000',border:'#4d0f05'})
            } 
        }).fail(function(data) {
            if (data.responseJSON != undefined) sendNoty(data.responseJSON.message,'error');
            else console.log(data);
            changeButtonColor(button,{main:'#f65353',fa:'#970000',border:'#4d0f05'})
        }).always(function() {
            myspinner.toggleClass('lds-circle');
        });
    });
JS;

$this->registerJs($js);

Modal::begin([
    'id' => 'modal',
    // 'size'=>'modal-lg',
    'options' => ['tabindex' => false],
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
        <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['protocolo/protocolo'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-star"></i> Asignados a mí', ['protocolo/asignados'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-pause-circle"></i> Pendientes', ['protocolo/'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-stop-circle"></i> Terminados', ['protocolo/terminados'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-list"></i> Todos', ['protocolo/all'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="clearfix"></div>
</div>
<div style="margin-top: 10px;">
    <?php
    $this->registerCss(".hasDatepicker {width:90px;}");
    echo GridView::widget([
        'dataProvider' => $dataProvider_entregados,
        'options' => array('class' => 'table table-striped table-lilac'),
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
                        'locale' => [
                            'format' => 'DD/MM/YYYY',
                            'separator' => ' - ',
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
                'attribute' => 'nombre',
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
                'attribute' => 'nro_documento',
                'contentOptions' => ['style' => 'width:6%;'],
            ],
            [
                'label' => 'Medico',
                'attribute' => 'nombre_medico',
                'contentOptions' => ['style' => 'width:25%;'],
            ],
            [
                'label' => 'Informes',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:10%;'],
                'value' => function ($model, $key, $index, $widget) {
                    $estados = ["1" => "danger", "2" => "default", "3" => "success", "4" => "warning", "5" => "primary", "6" => "info"];
                    $estadosLeyenda = [
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
                'value' => function ($model) {
                    $dataEstudio = $model['Estudio_id'];
                    $data = $model['informe_id'];
                    //urls acciones
                    $url            = Url::to(['informe/entregar', 'accion' => 'mail', 'id' => $data]);
                    $urlPrint       = Url::to(['informe/entregar', 'accion' => 'print', 'estudio' => $dataEstudio, 'id' => $data]);
                    $urlPublicar    = Url::to(['informe/publicar', 'accion' => 'publicar', 'estudio' => $dataEstudio, 'id' => $data]);
                    $urlVer         = Url::to(['informe/view',  'id' => $data]);
                    $urlEditar      = Url::to(['informe/update', 'id' => $data]);

                    return Html::a("<i class='fa fa-print'></i>", $urlPrint, [
                        'title' => Yii::t('app', 'Descargar/imprimir'),
                        'class' => 'btn btn-primary btn-xs',
                        'value' => "$urlPrint",
                        'data-id' => "$data",
                        'data-protocolo' => "$data",
                        'target' => '_blank',
                        'data-pjax' => 0
                    ]) . " " . Html::a("<i class='fa fa-envelope '></i>", null, [
                        'title' => Yii::t('app', 'Enviar por Mail'),
                        'class' => 'btn btn-primary btn-xs finalizado sendRequest ',
                        'value' => "$url",
                        'data-id' => "$data",
                        'data-protocolo' => "$data",
                        'ajax-before-send' => 'Se está procesando el envío de mail'
                    ])
                        . " " . Html::a("<i class='fa fa-cloud-upload'></i>", $urlPublicar, [
                            'title' => Yii::t('app', 'Publicar en WEB'),
                            'class' => 'btn btn-primary btn-xs sendRequest ',
                            'value' => "$urlPublicar",
                            'data-id' => "$data",
                            'data-protocolo' => "$data",
                            'ajax-before-send' => 'El informe se esta publicando en la web...'
                        ])
                        . " " . Html::a("<i class='fa fa-eye'></i>", $urlVer, [
                            'title' => Yii::t('app', 'Ver'),
                            'class' => 'btn btn-primary btn-xs ',
                            'value' => "$urlVer",
                            'data-id' => "$data",
                            'data-protocolo' => "$data",
                        ])
                        . " " . Html::a("<i class='fa fa-pencil'></i>", $urlEditar, [
                            'title' => Yii::t('app', 'Editar'),
                            'class' => 'btn btn-primary btn-xs',
                            'value' => "$urlEditar",
                            'data-id' => "$data",
                            'data-protocolo' => "$data",
                        ]) . "<div id='spinnerqw-$data' class=''><div></div></div>";
                },
            ],
        ]
    ]);
    ?>
</div>
</p>
<style>
    .summary {
        float: left;
    }

    .lds-circle {
        display: inline-block;
        transform: translateZ(1px);
    }

    .lds-circle>div {
        display: inline-block;
        width: 14px;
        height: 14px;
        margin-left: 10px;
        border-radius: 50%;
        background: #d8e150;
        animation: lds-circle 2.4s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    @keyframes lds-circle {

        0%,
        100% {
            animation-timing-function: cubic-bezier(0.5, 0, 1, 0.5);
        }

        0% {
            transform: rotateY(0deg);
        }

        50% {
            transform: rotateY(1800deg);
            animation-timing-function: cubic-bezier(0, 0.5, 0.5, 1);
        }

        100% {
            transform: rotateY(3600deg);
        }
    }
</style>