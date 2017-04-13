<?php 
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

                <?php Pjax::begin(['id' => 'grid-nomencladores']); ?>
                            <?php echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                'options'=>array('class'=>'table table-striped table-lilac'),
                                'columns' => [
                                    'estudio',
                                    'descripcion',
                                //    'nomencladores',

                                    ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete}',
                                    'buttons' => [
                                    //view button

                                     'delete' => function ($url, $model) {
                                        return Html::a('<span class="fa fa-trash"></span>', FALSE, [
                                                    'title' => Yii::t('app', 'Borrar'),
                                                    'class'=>'btn btn-danger btn-xs', 
                                                    'onclick'=>'deleteInformetemp('.$model->id.',"'.$url.'")', 
                                                    'value'=> "$url",
                                        ]);
                                        
                                    },        
                                ],

          
                              ],
                                 ],
                            ]); ?>

  <?php Pjax::end(); ?>