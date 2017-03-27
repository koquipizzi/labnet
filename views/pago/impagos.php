<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\Prestadoras;
use kartik\select2\Select2;
use vova07\select2\Widget;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EstudioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Informes Impagos');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    Modal::begin([
            'id' => 'modal',          
            'options' => ['tabindex' => false ],  
         //   'clientOptions' => ['backdrop' => false],
        ]);
        echo "<div id='modalContent'>"
    . "<!--img class='mr-15' src='@web/assets/global/img/loader/general/3.gif' -->"
                . "</div>";
       
            

        
?> 
<?php Modal::end(); ?>

  <?php 
  use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_contable.js', ['depends' => [yii\web\AssetBundle::className()]]);
     ?>


<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
<div class="body-content animated fadeIn" >    
<div class="estudio-index">
    
    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="float:right;">
        <?= Html::a(Yii::t('app', 'Nuevo Pago'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    
    
 
<?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
                                     <?php
                                            echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'options'=>array('class'=>'table table-striped table-lilac'),
                                            'filterModel' => $searchModel,    
                                            'columns' =>    [
                                                 
                                                 [
                                                    'label' => 'Nro Protocolo',
                                                    'attribute'=>'codigo', 
                                                ],
                                                [
                                                  'label' => 'Fecha Entrada',
                                                  'attribute' => 'fecha_entrada',
                                                  'value' => 'fecha_entrada',
                                                  'format' => ['date', 'php:d/m/Y'],
                                                  'filter' => \yii\jui\DatePicker::widget([
                                                      'model'=>$searchModel,
                                                      'attribute'=>'fecha_entrada',
                                                      'language' => 'es',
                                                      'dateFormat' => 'dd/MM/yyyy',
                                                  ]),

                                                ],
                                                [
                                                    'label' => 'Paciente',
                                                    'attribute'=>'nombre', 
                                                ], 
                                                [
                                                    'label' => 'Prestadora',
                                                    'attribute' => 'Prestadoras_id',
                                                    'value' => function ($model, $key, $index, $widget){
                                                        $prest=Prestadoras::find()->where(["id"=>$model["Prestadoras_id"]])->one();
                                                        return $prest->descripcion;
                                                
                                                    },
                                                    'filter' => Html::activeDropDownList($searchModel, 'Prestadoras_id', ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion'),['class'=>'form-control','prompt' => 'Seleccionar Prestadora']),
                                                    'contentOptions' => ['style' => 'width:20%;'],
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
//                                                        $idProtocolo = $model['id'];
//                                                        $informes = app\models\Informe::find()->where(['=','Informe.Protocolo_id',$idProtocolo])->all();
                                                        //var_dump($model['id']); die();
                                                    
                                                         //   var_dump($inf); 
                                                            $estado = $model["estado_actual"]; 
                                                            $tittle="'".$estadosLeyenda[$estado]."'";
                                                            $estado= $estados[$estado];
                                                            $clase = "'"." label rounded protoClass2 label-$estado"."'";
//                                                            $url ='index.php?r=informe/update&id='.$inf->id;
                                                            $val =  "<strog title=$tittle class=$clase > {$model['nombre_estudio']} </strong>";
                                                                    
                                                        $val = $val;
                                                        return $val;
                                                    },
                                                ],                                                    
                                                    
                                                
                                                ],

                                        ]); 
                                    ?>
                                    
<?php Pjax::end(); ?></div>
    </div>
</section>

<style>
    .summary{
        float:left;
    }

</style>
