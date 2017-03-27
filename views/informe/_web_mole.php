<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>
<div class="pagina">
    <div class="header_pap">
        <table>
            <tr>
                <td>
                    <!--
                    si hay problemas con la visualización de imágenes 
                    sudo apt-get install php5-gd
                    sudo service apache2 restart
                    -->
                    <div style="width:100px; float:left; font-size: 14px; margin: 20px; ">
                        <?php  echo Html::img( '@web' .$laboratorio->path_logo); ?>
                    </div> 
                </td>
            </tr>
            <tr>
                <td width="400px" style="padding-left: 20px; float: left;">
                    <table>
                        <tr>
                           <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PACIENTE </td><td><?php echo $modelp->pacienteText; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">DOCUMENTO </td><td><?php echo $modelp->pacienteDoc; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">EDAD </td><td><?php echo $model->edad; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PACIENTE </td><td>PACIENTE </td>
                        </tr>
                    </table>
                </td>
                <td width="400px" style="margin-left: 20px; float: right;">
                    <table>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PROTOCOLO</td><td><?php echo $modelp->codigo; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">FECHA</td><td><?php echo 'FECHA!!!!'; ?> </td>
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
    <h5 style="text-align: center; margin-left: 20px; font-weight: bold; text-decoration: underline">
        BIOLOGÍA MOLECULAR - HPV DNA TEST
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
            METODO
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->metodo); ?>
        </div>        
        <div class="pap_labels">            
            RESULTADO
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->resultado);  ?>
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
            <?php echo nl2br($model->observaciones); ?>
        </div>
    </div>
    
</div>

<div class="footer" style="position: fixed; bottom: -5px; text-align: center; font-size: 11px; width:100%">
    INFORMACIÓN CONFIDENCIAL - SECRETO MÉDICO - ALCANCES DEL ARTÍCULO 156 DEL CÓDIGO PENAL
</div>
    