<?php

use app\models\Informe;
use app\models\PacientePrestadora;
$nro_afiliado = PacientePrestadora::find()->where(['id' => $model->Paciente_prestadora_id])->one()->nro_afiliado;
if( empty($nro_afiliado) ){
    $nro_afiliado='No tiene, es particular.';
}
?>
                <table class="table table-striped">
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
                            <span class="pull-left text-strong"><?= $model->pacienteTexto ?></span>
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
                            <span class="pull-left text-strong"><?= $model->cobertura ?></span>
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <span class="pull-left text-capitalize">Nro. Afiliado</span>
                         </td>
                        <td>
                            <span class="pull-left text-strong"><?= $nro_afiliado ?></span>
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
 


