<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\bootstrap\Modal;
use app\models\Informe;

?>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Protocolo N°: <b><?= $model->codigo ?></b></h3>
        </div><!-- /.panel-heading -->
        <div class="panel-body no-padding">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Fecha Entrada</span>
                          </td>
                        <td>  <span class="pull-left text-strong"><?= $model->fechaEntregaOrdenada ?></span>
                        </td>
                    </tr>    
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Paciente</span>
                        </td>
                        <td>
                            <span class="pull-left text-strong"><?= $model->pacienteText ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Edad</span>
                         </td>
                        <td>    <span class="pull-left text-strong"><?= $model->pacienteEdad ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Médico</span>
                         </td>
                        <td>
                            <span class="pull-left text-strong"><?= $model->medico->nombre ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Cobertura/OS</span>
                         </td>
                        <td>
                            <span class="pull-left text-strong"><?= $model->prestadora->descripcion ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Procedencia</span>
                          </td>
                        <td>   <span class="pull-left text-strong"><?= $model->procedencia->descripcion ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Facturar a</span>
                         </td>
                        <td>
                            <span class="pull-left text-strong"><?= $model->facturarA->descripcion ?></span>
                        </td>
                    </tr>
<!--                                                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Pending transactions:</span>
                            <span class="pull-right text-strong fg-teals">$<span class="counter">34.11</span></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left text-capitalize">Reserves &amp; holds:</span>
                            <span class="pull-right text-strong">$<span class="counter">0.00</span></span>
                        </td>
                    </tr>-->
                    </tbody>
                </table>
            </div>
        </div><!-- /.panel-body -->
    </div>

<?php
            echo $this->render('//protocolo/_nomencladores', [
                'informe'=>$model, 'dataProvider'=> $dataProvider]) 

?>


 <?php 

//echo GridView::widget([
// 		'dataProvider' => $dataProvider,
// 		
// 		'columns' => [
// 				[ 'class'=>'kartik\grid\EditableColumn',
// 					'attribute'=>'valor',
//                                    'editableOptions' => [
//                                    'header' => 'Text',
//                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
//                                    'asPopover' => false,
//                                    ],
////                                        'editableOptions'=> function ($model, $key, $index) {
////                                        return [
////                                                        'header'=>'Name',
////                                                        'size'=>'md',
////                                                        'inputType'=>\kartik\editable\Editable::INPUT_TEXTAREA
////
////                                        ];
////					},
// 				],
//		
// 		],
// ]);

?>
