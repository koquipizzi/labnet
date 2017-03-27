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
 <?php Pjax::begin(['id' => 'prestadorasProtocolo']); ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,                                
                                'options'=>array('class'=>'table table-striped table-lilac'),
                                'summary' => '',
                                'columns' => [
                                    [
                                        'label' => 'Prestadora',
                                        'value' => 'prestadoraTexto',
                                    ],
                                    'nro_afiliado',
                                    ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{selectPrest}',
                                    'buttons' => [
                                    //view button
                                    
                                    
                                    'selectPrest' => function ($url, $model) {
                                        $url = 'index.php?r=protocolo/create17&pacprest='.$model->id;
                                        return Html::a('Nuevo Protocolo <i class="fa fa-arrow-circle-right"></i>', FALSE, [
                                                    'title' => Yii::t('app', 'Nuevo Protocolo'),
                                                    'class'=>'btn btn-primary btn-sm crearProtocolo', 
                                                    'onclick'=>'crearProtocolo('.$model->id.',"'.$url.'")', 
                                                    'value'=> "$url",
                                        ]);
                                    },
//                                    'crear' => function ($url, $model) {
//                                        return Html::a('<span class="fa fa-trash"></span>', FALSE, [
//                                                    'title' => Yii::t('app', 'Borrar'),
//                                                    'class'=>'btn btn-danger btn-xs', 
//                                                    'onclick'=>'deletePrestadora('.$model->id.',"'.$url.'")', 
//                                                    'value'=> "$url",
//                                        ]); 
//                                    },
                                ],

          
                              ],
                                 ],
                            ]); ?>

 <?php Pjax::end() ?>

