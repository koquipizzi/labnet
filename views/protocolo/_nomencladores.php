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

    <style>
        #popNomenclador {
            width: 200px;
            padding-right: 1px;
        }
    </style>
        <div class="panel-heading">            
                <!--div class="pull-left">
                    <h3 class="panel-title text-left">Nomencladores</h3>
                </div-->
                <div class="pull-right">
                    <div class="btn-group"> 
                       
                        <?php 
                            $data =  Nomenclador::find()->asArray()->all();
                            $data2 =  ArrayHelper::map($data, 'id', 'servicio');
                            
                            //$model->id = null;
                            $modelIN = $modeloInformeNomenclador;
                            $url = Url::to(['/informe-nomenclador/create']);
                            PopoverX::begin([
                                'placement' => PopoverX::ALIGN_TOP,
                                'id'=> 'popNomenclador',
                                'toggleButton' => ['label'=>'', 'class'=>' fa fa-plus'],
                                'header' => 'Agregar nomenclador',
                                'footer'=> Html::a('<span class="btn btn-info click"> Agregar</span>', $url)//Html::Button('Agregar', ['class'=>'btn btn-sm btn-primary click'])// .
                                        // Html::resetButton('Cancelar', ['class'=>'btn btn-sm btn-default'])
                            ]);
                           // echo $form->field($model, 'id_nomenclador')->textInput(['placeholder'=>'Nomenclador...']);
                            $form = ActiveForm::begin([
                                    'id' => 'addNom',
                                    'fieldConfig'=>['showLabels'=>false],                                   
                                     'action' => Url::to(['/informe-nomenclador/create']),
                                    ]);
                            
                            echo $form->field($modelIN, 'id_nomenclador',[
                                'template' => "{label}
                                            <div id='SelecNomenclador'>{input}</div>
                                            {hint}
                                            {error}"])->widget(Select2::classname(), [
                                    'data'=>$data2,'language'=>'es',
                                    'toggleAllSettings' => [                                    
                                    'selectOptions' => ['class' => 'text-success'],
                                    'unselectOptions' => ['class' => 'text-danger'],
                                     ],
                                    'options' => ['multiple' => false]
                            ]);
                            echo $form->field($modelIN, 'cantidad')->textInput(['placeholder'=>'Cantidad...']);
                            echo $form->field($modelIN, 'id_informe')->hiddenInput( array('value'=>$informe->id))->label(false);
                            ActiveForm::end(); 
                            PopoverX::end();
                            
                        ?>
                       
                        <?php //echo Html::button('<i class="fa fa-plus"></i>', ['data-url' => Url::to(['/informe/addnomenclador/', 'id'=> '12']),'title' => 'Agregar Nomenclador', 'class' => 'addNomenclador btn btn-sm']); ?>
                    
                    </div>
                    <!--button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Minimizar"><i class="fa fa-angle-up"></i></button-->
                </div>
                <div class="clearfix"></div>
        </div><!-- /.panel-heading -->
        <div class="panel-body no-padding">
            <div class="table-responsive">
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
                            <span class="pull-left text-capitalize"><?php  $nome->servicio ?></span>
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
            </div>
        </div><!-- /.panel-body -->
