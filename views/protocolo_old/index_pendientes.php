<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use kartik\widgets\DatePicker;

$this->title = Yii::t('app', 'Protocolos');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 

    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/global/plugins/bower_components/peity/jquery.peity.min.js', ['depends' => [yii\web\AssetBundle::className()]]);
    $this->registerJsFile('@web/assets/admin/css/components/rating.css', ['depends' => [yii\web\AssetBundle::className()]]);
    
    ?>
                <!--div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">Protocolos Pendientes</h3>
                        <i class="fa fa-tasks"></i>                   
                        <span class="text-strong">Informes por protocolo</span>
                    </div>
                    <div class="pull-right">
                        <?= Html::a('Asignados', Url::to(['protocolo/asignados']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>
                        <?= Html::a('Terminados', Url::to(['protocolo/terminados']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>
                        <?= Html::a('Entregados', Url::to(['protocolo/entregados']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>    
                        <?= Html::button('Nuevo Protocolo', ['value' => Url::to(['paciente/']), 'title' => 'Nuevo Protocolo', 'class' => 'loadMainContentProtocolo btn btn-success btn-sm']); ?>
                    </div>   
                    <div class="clearfix"></div>
                </div-->
        <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Protocolos Pendientes</h3>
                 <i class="fa fa-tasks"></i>                   
                <span class="text-strong">Informes por protocolo</span>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Protocolo', ['protocolo/create'], ['class'=>'btn btn-primary']) ?>
            </div> 
            <div class="clearfix"></div>
        </div>
                
            <!-- Start tabs content -->
            <div style="margin-top: 10px;">
                <?php 
            //    $this->registerCss(".hasDatepicker {                                    
            //                        width:90px;}");

                Pjax::begin(['id' => 'pendientes', 'enablePushState' => false]) ?> 
                <?php  
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options'=>array('class'=>'table table-striped table-lilac'),
                    'filterModel' => $searchModel,   
                    'columns' => [//'id', 
                        [
                            'label' => 'Fecha Entrada',
                            'attribute' => 'fecha_entrada',
                            'format' => ['date', 'php:d/m/Y'],
                         /*   'filter' => \yii\jui\DatePicker::widget([
                                'model'=>$searchModel,
                                'attribute'=>'fecha_entrada',
                                'language' => 'es',
                                'dateFormat' => 'dd/MM/yyyy',
                            ]),*/
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
                            'contentOptions' => ['style' => 'width:10%;'],
                        ],                                                    
                        [ 
                            'label' => 'Informes',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:30%;'],
                            'value'=>function ($model, $key, $index, $widget) { 
                                $estados = array( 
                                    "1" => "danger", 
                                    "2" => "inverse", 
                                    "3" => "success",
                                    "4" => "warning", 
                                    "5" => "primary", 
                                    "6" => "lilac",
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
                                $val = $val."<span></span>";}
                                return $val;
                            },
                        ],                   
                     ],         
                ]); 
                ?>
                <?php Pjax::end() ?>
            </div>  




