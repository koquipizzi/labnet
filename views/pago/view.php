

<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
   use yii\grid\GridView;  
/* @var $this yii\web\View */
/* @var $model app\models\Estudio */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estudios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>        
    </div><!-- /.header-content -->
    
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="estudio-view">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Pago

                        <p style="float: right;">
                     
                    </p>
                    </h3>
                </div>
                    <div class="row">
                        <div class=" col-lg-8 " style="margin-left:10%;">
                        <h3>Información del Pago</h3>
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                  'label' => 'Fecha',
                                  'attribute'=>'fechaseteada'
                                ],
                                 [
                                  'label' => 'Importe',
                                  'attribute'=>'importeSeteado',
                                  
                                ],
                                [
                                  'label' => 'Número Formulario',
                                  'attribute'=>'nro_formulario'
                                ],
                                [
                                    'label' => 'Prestadoras',
                                   'attribute'=>'prestadoraName' 
                                ],
                                [
                                    'label' => 'Observaciones',
                                   'attribute'=>'observacionesseteada' 
                                ],
                                
                            ],
                        ]) ?>
                    </div>     
                  </div> 
                <div class="row">
                    <div class=" col-lg-8" style="margin-left:10%;">
                
                        <h3>Informes</h3>
                                    <?php
                                           echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'options'=>array('class'=>'table table-striped table-lilac', "style"=>"margin-top:20px; float: middle;"),
                                            'filterModel' => $searchModel,    
                                            'columns' =>    [
                                                 
                                                 [
                                                    'label' => 'Nro Protocolo',
                                                    'attribute'=>'codigo', 
                                                ],

                                                [
                                                    'label' => 'Paciente',
                                                    'attribute'=>'nombre', 
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

                                        ]); ?> 
                    </div>    
            </div>
                
        </div>
    </div>
</section>
