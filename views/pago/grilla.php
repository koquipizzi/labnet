<?php
//use kartik\grid\GridView;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;

    echo GridView::widget([
        'id'=>"gridFacturable",
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac', 'style'=>'margin-top:20px'),
        'filterModel' => $searchModel,
        'columns' => [//'id',

             [

                'class' => 'yii\grid\CheckboxColumn',
                 'checkboxOptions' =>  function ($model, $key, $index, $column) {
                  return ['value' => $model["id"]];


                 },
                 'name'=>'p[]',
                 'contentOptions' => ['style' => 'width:5%;', 'class'=>'checkPagos'],
             ],
            [
                'label' => 'Fecha Entrada',
                'attribute' => 'fecha_entrada',
                'value' => 'fecha_entrada',
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
                                                    'format' => 'dd/mm/yyyy',
                                                    'startView' => 'date',
                                                ]
                                        ] ),

            'contentOptions' => ['style' => 'width:5%;'],
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
            ],

            [
                'label' => 'Informes',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:35%;'],
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
                    $informes = app\models\Informe::find()->where(['Informe.Protocolo_id'=>$idProtocolo, "Pago_id"=>NULL])->all();
                    foreach ($informes as $inf){
                        $estado = $inf['estado_actual'];
                        $clase = " label-".$estados[$estado];
                        $clase ='label '. $clase.' rounded protoClass2';
                        $name="i[{$idProtocolo}][]";
                            $val = $val. "<b class='$clase' >{$inf->estudio->nombreCorto }</b>";
                         $val = $val."<span></span> ";

                    }
//                     if(strlen($val)>32){
//                         $val= substr ( $val , 0 ,  32  );
//                         $val= $val. "...";
//                    }
                    return $val;
                },
            ],
         ],
        ]);
 ?>
