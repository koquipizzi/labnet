<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\editable\Editable;
use kartik\popover\PopoverX;
use kartik\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\Nomenclador;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>
        <div class="panel-body no-padding">
                <?php Pjax::begin(['id' => 'nomencladores']); ?>
                <table class="table">
                    <tbody>
                    
                    <?php 
                    $nom = $dataProvider->models;
                 //    var_dump($dataProvider);die();
                    foreach ($nom as $value) {
                       // $dataEstado=Estado::find('')->asArray()->all(); 
                        $nome = app\models\Nomenclador::find()->where(['id' => $value->id_nomenclador])->one();
                      //  echo $nom[]>servicio;
                  //     var_dump($value);die();
                    ?>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize"><?php  echo $nome->servicio ?></span>
                        </td>
                        <td>
                            <span class="pull-right text-strong">
                             <?php  $id_ni = (string)$value->id; 
                                $nom_id = "nom-".$id_ni;
                           //     yii\widgets\Pjax::begin(['id' => $nom_id, 'enablePushState' => false]);
                                ?>    
                                <?php 
                                $response = $value->cantidad;
                                $id_ni = (string)$value->id;    //    echo "-";  var_dump($id_ni); die();
                                $hid =   "<input type=\"hidden\" name=\"id_nomenclador_informe\" value=\"".$id_ni."\">";
                                $editable = Editable::widget([                                    
                                        'name'=>'cantidad', 
                                        'asPopover' => false,
                                        'value'=>$response,
                                        'header' => FALSE,
                                        'size'=>'xs',
                                        'options' => ['class'=>'form-control', 'placeholder'=>'Cantidad...'],
                                        'afterInput'=>
                                                Html::hiddenInput('id_nom_inf',$id_ni),
                                    ]);
                  //              $editable->beforeInput = Html::hiddenInput('kv-editable-depdrop', 1) ;
                                echo $editable;                                      
                                echo Html::a('<span class="glyphicon glyphicon-trash deleteNomenclador" id="'.$id_ni.'"></span>');   
                          
                                
                                ?>
                            <?php //yii\widgets\Pjax::end(); ?>
                            </span>
                        </td>
                    </tr>
                    <?php 
                    }
                    ?>
                     
                    </tbody>
                </table>
                <?php Pjax::end(); ?>
        </div><!-- /.panel-body -->
