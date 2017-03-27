<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;

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
                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                        <i class="fa fa-user"></i>                   
                        <span class="text-strong">Asignados a mí</span>
                    </div>
                    <div class="pull-right">
                        <?= Html::a('Pendientes', Url::to(['protocolo/']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>
                         <?= Html::a('Terminados', Url::to(['protocolo/terminados']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>    
                        <?= Html::a('Entregados', Url::to(['protocolo/entregados']), ['class' => 'btn btn-twitter btn-stroke btn-sm']); ?>    
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
                Pjax::begin(['id' => 'asignados', 'enablePushState' => false]);
                echo GridView::widget([
//                                    'id'=>'asignados',
                    'dataProvider' => $dataProvider_asignados,
                    'options' => array('class' => 'table table-striped table-lilac'),
                    'filterModel' => $searchModelAsig,
                    'columns' => [//'id', 
                        [
                            'label' => 'Fecha Entrada',
                            'attribute' => 'fecha_entrada',
                            'format' => ['date', 'php:d/m/Y'],
                            'filter' => \yii\jui\DatePicker::widget([
                                'model'=>$searchModelAsig,
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
                                'model'=>$searchModelAsig,
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
                            'attribute' => 'nro_documento',
                            'contentOptions' => ['style' => 'width:20%;'],
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
                        $estado = $model['lastEstado'];
                        $clase = " label-" . $estados[$estado];
                        $informes = app\models\Informe::find()->where(['=', 'Informe.Protocolo_id', $idProtocolo])->all();
                        //var_dump($model['id']); die();
                        $url = 'index.php?r=informe/update&id=' . $model['informe_id'];
                        $val = $val . Html::a(Html::encode($model['nombre_estudio']), $url, [
                                    'title' => "$estadosLeyenda[$estado]",
                                    'class' => 'label ' . $clase . ' rounded protoClass2',
                                    'value' => "$url",
                                    'data-id' => $model['informe_id'],
                                    'data-protocolo' => $model['id'],
                        ]);
                        $val = $val . "<span></span>";
                        return $val;
                    },
                        ],
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

    
    



