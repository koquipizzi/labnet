<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>
<div class="pagina">
    <div class="header_pap">
    </div>
   
    <div class="ContainerDataProtocolo">
            <div   class="ContainerDataFecha">
                 <?php echo $modelp->fechaEntrega; ?>
            </div>   
            <div   class="ContainerData">
                <div class="labelprotocoloCodigo"  >
                    Protocolo:
                </div>
                <div class="descriptionProtocoloCodigo"  >
                          <?php echo $modelp->codigo; ?>
                </div>
            </div>
            <div   class="ContainerDataPaciente">
                <div class="labelprotocoloPaciente"  >
                    Paciente:
                </div>
                <div class="descriptionProtocoloPaciente"  >
                         <?php echo $modelp->pacienteText;  ?>
                </div>
            </div>        
            <div   class="ContainerData">
                <div class="labelprotocoloMedico"  >
                    Médico:
                </div>
                <div class="descriptionProtocoloMedico"  >
                           <?php  echo $modelp->medico->nombre;   ?>
                </div>
            </div>   
            <div   class="ContainerDataEdad">
                <div class="labelprotocoloEdad"  >
                    Edad:
                </div>
                <div class="descriptionProtocoloEdad"  >
                           <?php echo $model->edad; ?>
                </div>
            </div>           

    </div>
    <h5 style="text-align: center; margin-left: 20px; font-weight: bold; text-decoration: underline">INFORME INMUNOHISTOQUÍMICO</h5>
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
            <?php echo nl2br($model->macroscopia)  ?>
        </div>
        <div class="pap_labels">
            MICROSCOPÍA
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->microscopia) ?>
        </div>
        <div class="pap_labels">
            DIAGNÓSTICO
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->diagnostico)  ?>
        </div>
        <div class="pap_labels">
            OBSERVACIONES
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->observaciones)  ?>
        </div>
    </div>
    
</div>

<div class="footer" style="position: fixed; bottom: -5px; text-align: center; font-size: 11px; width:100%">
    INFORMACIÓN CONFIDENCIAL - SECRETO MÉDICO - ALCANCES DEL ARTÍCULO 156 DEL CÓDIGO PENAL
</div>
    