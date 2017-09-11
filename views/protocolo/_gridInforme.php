<?php 
//use app\assets\admin\dashboard\DashboardAsset;

//DashboardAsset::register($this);


use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;
?>

          <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options'=>array('class'=>'table table-condensed'),
                        'summary' => '',
                        'columns' =>
                            [
                                'estudio.nombre',
                                'descripcion',
                                'observaciones',
                                'nomencladores',
                                [
                                    'attribute' => 'QR',
                                    'filter' => false,
                                    'format' => 'raw',
                                     'value' => function ($data) {
                                         return "<img src='". Url::to(['/protocolo/qr-code', 'id' => $data->id])."' width='100'/>";
                                         
                                     },
                                  ],
                                  

 
//                                ['class' => 'yii\grid\ActionColumn',
//                                    'template' => '{delete}',
//                                    'buttons' => [
//                                        
//                                     'delete' => function ($url, $model) {
//                                        return Html::a('<span class="fa fa-trash"></span>', FALSE, [
//                                                    'title' => Yii::t('app', 'Borrar'),
//                                                    'class'=>'btn btn-danger btn-xs', 
//                                                    'onclick'=>'deleteInforme('.$model->id.',"'.$url.'")', 
//                                                    'value'=> "$url",
//                                        ]);
//                                        
//                                    }, 
//
//                                    ],
//                                    'urlCreator' => function ($action, $model, $key, $index) {
//                                        if ($action === 'delete') {
//                                            $url ='index.php?r=informe/delete&id='.$model->id;
//                                            return $url;
//                                        }
//
//                                    }
//
//
//                                ],
                            ],
                    ]); ?>