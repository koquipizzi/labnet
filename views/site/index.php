<?php

/* @var $this yii\web\View */
use dosamigos\chartjs\ChartJs;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'LabNET - Administración de Informes Patológicos';
?>

      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pacientes</span>
              <span class="info-box-number"><?= $c ?><small> Totales</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-file"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Informes</span>
              <span class="info-box-number"><?= $i ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-maroon"><i class="fa fa-venus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PAPs</span>
              <span class="info-box-number"><?= $p ?><small></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-teal"><i class="fa fa-cogs"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Configuración</span>
              <span class="info-box-number"><small></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
     </div>
        <!-- /.row -->   

    <div class="box box-default">
                 <div class="box-header with-border">
                <!--i class="fa fa-warning"></i-->
                    <h3 class="box-title">Estadísticas de Estudios</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div class="row">
                    <div class="col-lg-8">       
                        <?= ChartJs::widget([
                                'type' => 'line',
                                'data' => [
                                    'labels' => $meses,
                                    'datasets' => [
                                        [
                                            'label' => 'Protocolos mensuales',
                                            'data' => $cantidades,
                                    
                                        ]
                                    ],
                                ],
                                'options' => [
                                    'height' => 200,
                                    'width' => 500,
                                ],
                                'clientOptions' => [
                                    'title' => [
                                        'display' => false,
                                        'text' => 'Tipos de Estudios Analizados'            
                                    ],
                                    'scales' => [
                                        'yAxes' => [
                                            [
                                                'scaleLabel' => [
                                                    'display' => 'true',
                                                    'labelString' => 'Protocolos / Mes'
                                                ]
                                            ]
                                        ],
                                        'xAxes' => [
                                            [
                                                'scaleLabel' => [
                                                        'display' => 'true',
                                                    'labelString' => 'Períodos (meses)'
                                                ]
                                            ]
                                        ]
                                    ],
                                ]
                            ]);?>
                            </div>
                    <div class="col-lg-4">
                        <?= ChartJs::widget([
                            'type' => 'doughnut',
                            'data' => [
                                'labels' => ['PAP', 'Biopsia', 'Citología', 'Molecular', 'InmunoH'],
                                'datasets' => [
                                    [
                                        'label' => 'Cantidad',
                                        'data' => [$p, $b, $ci, $m, $in],
                                    'backgroundColor' => [
                                        "#FF6384",
                                        "#36A2EB",
                                        "#FFCE56",
                                        '#605ca8',
                                        '#39cccc'
                                    ],
                                    ]
                                ],
                            ],
                            'options' => [
                               'height' => 200,
                            //    'width' => 500,
                            ],
                            'clientOptions' => [
                                'title' => [
                                    'display' => false,
                                    'text' => 'Tipos de Estudios Analizados'            
                                ],
                                'scales' => [
                            //          'yAxes' => [
                            //              [
                            //                  'scaleLabel' => [
                            //                      'display' => 'true',
                            //                       'labelString' => 'level'
                            //                   ]
                            //               ]
                            //           ],
                            //           'xAxes' => [
                            //               [
                            //                   'scaleLabel' => [
                            //                        'display' => 'true',
                            //                       'labelString' => 'time spent'
                            //                   ]
                            //               ]
                            //           ]
                                ],
                            ]
                        ]);?>
                    </div>
            </div>
            </div>
         </div>


    <div class="row">
        <div class="col-lg-6">
            <div class="box box-default">
                <div class="box-header with-border">
                <i class="fa fa-warning"></i>

                <h3 class="box-title">Tipos de Estudios</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <?= ChartJs::widget([
                        'type' => 'bar',
                        'data' => [
                            'labels' => ['PAP', 'Biopsia', 'Citología', 'Molecular', 'InmunoH'],
                            'datasets' => [
                                [
                                    'label' => [$p, $b, $ci, $m, $in],
                                    'data' => [$p, $b, $ci, $m, $in],
                                'backgroundColor' => [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                ]
                            ],
                        ],
                        'options' => [
                            'height' => 350,
                            'width' => 500,
                        ],
                        'clientOptions' => [
                            'title' => [
                                'display' => false,
                                'text' => 'Tipos de Estudios Analizados'            
                            ],
                            'scales' => [
                        //          'yAxes' => [
                        //              [
                        //                  'scaleLabel' => [
                        //                      'display' => 'true',
                        //                       'labelString' => 'level'
                        //                   ]
                        //               ]
                        //           ],
                        //           'xAxes' => [
                        //               [
                        //                   'scaleLabel' => [
                        //                        'display' => 'true',
                        //                       'labelString' => 'time spent'
                        //                   ]
                        //               ]
                        //           ]
                            ],
                        ]
                    ]);?>
                </div>
            </div>
        </div>
         <div class="col-lg-6">
         <div class="box box-primary">
                <div class="box-header with-border">
                <i class="fa fa-user"></i>

                <h3 class="box-title">Asignados</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <?php
                 Pjax::begin(['id' => 'asignados', 'enablePushState' => false]);
                echo GridView::widget([
                    'dataProvider' => $propios,
                    'options' => array('class' => 'table table-striped '),
                 //   'filterModel' => $search,
                    'columns' => [
                        //'id', 
                        
                        
                        [
                            'label' => 'Nro Protocolo',
                            'attribute' => 'codigo',
                            'contentOptions' => ['style' => 'width:10%;'],
                        ],
                        [
                            'label' => 'Fecha Entrada ',
                            'attribute' => 'fecha_entrada',
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
                Pjax::end() ?>  
                </div>
        </div>
         </div>

    </div>

    <div>
     
               

    </div>

