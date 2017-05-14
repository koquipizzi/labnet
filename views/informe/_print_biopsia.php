<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>
<div class="pagina">
    <div class="header_pap">
        <table>
            <tr>
                <td>
                   
                </td>
            </tr>
            <tr>
                <td width="400px"  style="padding-top: 180px; padding-left: 20px; float: left;">
                    <table class="header_pap">
                        <tr>
                           <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PACIENTE </td><td><?php echo $modelp->pacienteTexto; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">DOCUMENTO </td><td><?php echo $modelp->pacienteDoc ? $modelp->pacienteDoc : "Sin datos" ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">EDAD </td><td><?php echo $model->edad == 0 ? "Sin datos" : $model->edad; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">COBERTURA </td><td><?php echo $modelp->procedencia->descripcion; ?>  </td>
                        </tr>
                    </table>
                </td>
                <td width="400px" style="margin-left: 20px;padding-top: 180px; float: right;">
                    <table class="header_pap">
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PROTOCOLO</td><td><?php echo $modelp->codigo; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">FECHA</td><td><?php echo $modelp->fechaEntrega;  ?>  </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">MÉDICO </td><td><?php echo $modelp->medico->nombre; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PROCEDENCIA </td><td><?php echo $modelp->procedencia->descripcion; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <h5 style="font-size:13px; text-align: center; margin-left: 20px; font-weight: bold; text-decoration: underline">
        INFORME ANATOMOPATÓLOGICO
    </h5>
    <div class="informe">
        <div class="pap_labels">
            MATERIAL
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->material); ?>
            <br><br>
            <?php echo nl2br($model->tecnica); ?>
        </div>        
        <div class="pap_labels">
            MACROSCOPÍA
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->macroscopia); ?>
        </div>
        <div class="pap_labels">
            MICROSCOPÍA
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->microscopia); ?>
        </div>
        <div class="pap_labels">
            DIAGNÓSTICO
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->diagnostico);  ?>
        </div>
        <div class="pap_labels">
            OBSERVACIONES
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->observaciones);  ?>
        </div>
    </div>
    
</div>

<div class="footer" style="position: fixed; bottom: -5px; text-align: center; font-size: 11px; width:100%">
    INFORMACIÓN CONFIDENCIAL - SECRETO MÉDICO - ALCANCES DEL ARTÍCULO 156 DEL CÓDIGO PENAL
</div>
    