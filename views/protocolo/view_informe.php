<?php

use app\models\Informe;

?>
                <table class="table table-striped">
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
                    </tbody>
                </table>
 


