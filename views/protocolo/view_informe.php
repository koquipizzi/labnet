<?php

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
                            <span class="pull-left text-capitalize">Entrada</span>
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
                'model' => $model, 'informe'=>$informe,  'dataProvider'=> $dataProvider, 'modeloInformeNomenclador' => $modeloInformeNomenclador]) 

?>

