<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use jino5577\daterangepicker\DateRangePicker;

$this->title = Yii::t('app', 'Protocolos');
$this->params['breadcrumbs'][] = $this->title;

    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/global/plugins/bower_components/peity/jquery.peity.min.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/admin/css/components/rating.css', ['depends' => [yii\web\AssetBundle::className()]]);
    
    ?>

        <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Protocolos asignados a mí</h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['paciente/buscar'], ['class'=>'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-pause-circle"></i> Pendientes', ['protocolo/'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-stop-circle"></i> Terminados', ['protocolo/terminados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-check"></i> Entregados', ['protocolo/entregados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-list"></i> Todos', ['protocolo/all'], ['class'=>'btn btn-primary']) ?>
            </div> 
            <div class="clearfix"></div>
        </div>
            

            <!-- Start tabs content -->
            <div style="margin-top: 10px;">
                <?php
                Pjax::begin(['id' => 'asignados', 'enablePushState' => false]);
                echo GridView::widget([
                    'dataProvider' => $dataProvider_asignados,
                    'options' => array('class' => 'table table-striped '),
                    'filterModel' => $searchModelAsig,
                    'columns' => [
                        //'id', 
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
                                 'model' => $searchModelAsig, 
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
                                'model' => $searchModelAsig, 
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
                            'contentOptions' => ['style' => 'width:10%;'],
                        ],
                        [
                            'label' => 'Paciente',
                            'attribute'=>'nombre', 
                             'contentOptions' => ['style' => 'width:20%;'],
                            'value'=>function ($model, $key, $index, $widget) { 
                                if(strlen($model["nombre"])>20){
                                    return substr($model["nombre"], 0, 17)."...";
                                }  else {
                                       return $model["nombre"];
                                }
                            }
                        ],
                        [
                            'label' => 'Documento',
                            'attribute' => 'nro_documento',
                            'contentOptions' => ['style' => 'width:10%;'],
                        ],
                        [
                            'label' => 'Informes',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:30%;'],
                            'value' => function ($model, $key, $index, $widget) {
                        $estados = array(
                            "1" => "danger",
                            "2" => "inverse",
                            "3" => "success",
                            "4" => "warning",
                            "5" => "primary",
                            "6" => "default",
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
                    ],
                ]);
                ?>
                <?php Pjax::end() ?>  

            </div>  
            </p>       



    <!--/ End double tabs -->



<style>
    .summary{
        float:left;
    }


</style>



    
    



