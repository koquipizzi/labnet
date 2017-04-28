<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use mdm\admin\components\Helper;
use jino5577\daterangepicker\DateRangePicker;
use app\models\Informe;

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

    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/global/plugins/bower_components/peity/jquery.peity.min.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/admin/css/components/rating.css', ['depends' => [yii\web\AssetBundle::className()]]);
    
    ?>
      <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Protocolos Terminados</h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['paciente/buscar'], ['class'=>'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-star"></i> Asignados a mí', ['protocolo/asignados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-pause-circle"></i> Pendientes', ['protocolo/'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-check"></i> Entregados', ['protocolo/entregados'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-list"></i> Todos', ['protocolo/all'], ['class'=>'btn btn-primary']) ?>
            </div> 
            <div class="clearfix"></div>
        </div>
            

            <!-- Start tabs content -->
            <div style="margin-top: 10px;">
                <?php
                $this->registerCss(".hasDatepicker {                                    
                                    width:90px;}");
                Pjax::begin(['id' => 'terminados']);
               
                                echo GridView::widget([
                                'dataProvider' => $dataProvider_terminados,
                                'options'=>array('class'=>'table table-striped'),
                                'filterModel' => $searchModel,    
                                'columns' =>    [ //'id',
                                     //   'value'=>'estudio',
                                     [
                                        'label' => 'Fecha de Entrada',
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
                                        'contentOptions' => ['style' => 'width:10%;'],
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
                                        'label' => 'Documento',
                                        'attribute'=>'nro_documento', 
                                        'contentOptions' => ['style' => 'width:10%;'],
                                    ],
                                    [
                                        'label' => 'Informe',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:10%;'],
                                        'value'=> function ($model) { 
                                            return '<a class="label label-default rounded protoClass2">'.$model['nombre_estudio'].'</a>';                                                        
                                        }
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

                                                    return Html::a(" <span class='fa fa-print'></span>",$urlPrint,[
                                                        'title' => Yii::t('app', 'Descargar/imprimir'),
                                                        'class'=>'btn btn-primary btn-xs', 
                                                        'value'=> "$urlPrint",       
                                                        'data-id'=> "$data",  
                                                        'data-protocolo'=> "$data",
                                                        'target'=>'_blank',
                                                    ])."  " .Html::a(" <span class='fa fa-envelope'></span>",$url,[
                                                        'title' => Yii::t('app', 'Enviar por Mail'),
                                                        'class'=>'btn bg-olive btn-xs', 
                                                        'value'=> "$url",       
                                                        'data-id'=> "$data",  
                                                        'data-protocolo'=> "$data",  
                                                    ])."  " . Html::a("<i class='fa fa-cloud-upload'></i>",$url,[
                                                        'title' => Yii::t('app', 'Publicar en WEB'),
                                                        'class'=>'btn btn-primary btn-xs', 
                                                        'value'=> "$urlPublicar",       
                                                        'data-id'=> "$data",  
                                                        'data-protocolo'=> "$data",  
                                                    ])
                                                    . "  " .Html::a("<i class='fa fa-eye'></i>",$urlVer,[
                                                        'title' => Yii::t('app', 'Ver'),
                                                        'class'=>'btn bg-olive btn-xs', 
                                                        'value'=> "$urlVer",       
                                                        'data-id'=> "$data",  
                                                        'data-protocolo'=> "$data",  
                                                    ])        
                                                    ."  " . Html::a("<i class='glyphicon glyphicon-pencil'></i>",$urlEditar,[
                                                        'title' => Yii::t('app', 'Editar'),
                                                        'class'=>'btn btn-primary btn-xs', 
                                                        'value'=> "$urlEditar",       
                                                        'data-id'=> "$data",  
                                                        'data-protocolo'=> "$data",  
                                                    ]);
                                                      
                                                
                                                    },
                                                 ],     
                                       /*                  ['class' => 'yii\grid\ActionColumn',
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
                                                    ] */                                                                                                   
                                                ],
                                        ]); 
                                    ?>
                <?php Pjax::end() ?>  

            </div>  
            </p>       


<style>
    .summary{
        float:left;
    }


</style>

    
    



