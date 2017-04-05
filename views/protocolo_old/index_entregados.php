<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use mdm\admin\components\Helper;
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
                        <h3 class="panel-title">Informes entregados</h3>
                        <i class="fa fa-send"></i>                   
                        <span class="text-strong">por web, mail e impresos</span>
                    </div>
                    <div class="pull-right">
                         <?= Html::a('Pendientes', Url::to(['protocolo/']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>
                        <?= Html::a('Asignados', Url::to(['protocolo/asignados']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>    
                        <?= Html::button('Nuevo Protocolo', ['value' => Url::to(['protocolo/create']), 'title' => 'Nuevo Protocolo', 'class' => 'loadMainContentProtocolo btn btn-success btn-sm']); ?>
                    </div>   
                    <div class="clearfix"></div>
                </div>
            </div>

            <!-- Start tabs content -->
            <div style="margin-top: 10px;">
                <?php
                $this->registerCss(".hasDatepicker {                                    
                                    width:90px;}");
                Pjax::begin(['id' => 'entregados']);
                echo GridView::widget([
//                                    'id'=>'asignados',
                    'dataProvider' => $dataProvider_entregados,
                     'options'=>array('class'=>'table table-striped table-lilac'),
                                            'filterModel' => $searchModel,    
                                            'columns' =>    [
                                                
                                                 //   'value'=>'estudio',
                                                [
                                                    'label' => 'Fecha Entrada',
                                                    'attribute' => 'fecha_entrada',
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
                                                                $urlVer ='index.php?r=informe/view&id='.$model['informe_id'];
                                                                $urlEditar ='index.php?r=informe/update&id='.$model['informe_id'];

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
                                                                ])
                                                                . Html::a("<i class='glyphicon glyphicon-zoom-in'></i>",$urlVer,[
                                                                    'title' => Yii::t('app', 'Ver'),
                                                                    'class'=>'label label-teal rounded ', 
                                                                    'value'=> "$urlVer",       
                                                                    'data-id'=> "$data",  
                                                                    'data-protocolo'=> "$data",  
                                                                ])        
                                                                . Html::a("<i class='glyphicon glyphicon-pencil'></i>",$urlEditar,[
                                                                    'title' => Yii::t('app', 'Editar'),
                                                                    'class'=>'label label-teal rounded ', 
                                                                    'value'=> "$urlEditar",       
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
                                                    ]                                                                                                    

                                                ],
                                        ]); 
                                    ?>
                <?php Pjax::end() ?>  

            </div>  
            </p>       


        </div>

    </div><!-- /.panel -->
    <!--/ End double tabs -->

    <!-- Start footer content -->
    <?php echo $this->render('/shares/_footer_admin'); ?>
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

    
    



