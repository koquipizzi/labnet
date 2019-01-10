<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>
<div class="pagina">
    <div class="header_pap">
    <div class="ContainerLab">
        <?php echo $laboratorio->nombre; ?>
    </div>  
    <div class="ContainerDataProtocolo">
        <div class="ContainerData">
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
                <?php echo $modelp->pacienteTexto;  ?>
            </div>
        </div>  
        <div class="ContainerDataDni">
            <div class="labelprotocoloDni"  >
                DNI:
            </div>
            <div class="descriptionProtocoloDni"  >
                <?php echo $modelp->pacienteDoc; ?>
            </div>
        </div>                 
    </div>
    <div class="ContainerDataProtocolo">              
        <div class="ContainerDataCobertura">
            <div class="labelprotocoloCobertura"  >
                Cobertura:
            </div>
            <div class="descriptionProtocoloCobertura"  >
                <?php echo $modelp->cobertura; ?>
            </div>
        </div> 
        <div   class="ContainerDataMedico">
            <div class="labelprotocoloMedico"  >
                Médico:
            </div>
            <div class="descriptionProtocoloMedico"  >
                <?php  echo $modelp->medico->nombre;   ?>
            </div>
        </div> 
    </div>    
    <div class="titulo">
       INFORME INMUNOHISTOQUÍMICO
    </div> 
    <div class="informe">         
        <div class="contenedorInforme">   
            <div class="labeInforme">
                MATERIAL
            </div>    
            <div class="camposInforme">
                <?php echo nl2br($model->material); ?>
            </div>
        </div> 
        <div class="contenedorInforme">   
            <div class="labeInforme">   
                TÉCNICA
            </div>    
            <div class="camposInforme">
                <?php echo nl2br($model->tecnica); ?>
            </div>     
        </div>
        <div class="contenedorInforme">   
            <div class="labeInforme">   
                MACROSCOPÍA
            </div>
            <div class="camposInforme">
                <?php echo nl2br($model->macroscopia)  ?>
            </div>     
        </div>  
        <div class="contenedorInforme">   
            <div class="labeInforme">   
                MICROSCOPÍA
            </div>
            <div class="camposInforme">
                <?php echo nl2br($model->microscopia) ?>
            </div>     
        </div>           
        <div class="contenedorInforme">   
            <div class="labeInforme">   
                DIAGNÓSTICO
            </div> 
            <div class="camposInforme">
                <?php echo nl2br($model->diagnostico);  ?>
            </div>     
        </div>  
        <div class="contenedorInforme">   
            <div class="labeInforme">   
                OBSERVACIONES
            </div>
            <div class="camposInforme">
                <?php echo nl2br($model->observaciones); ?>
            </div>     
        </div> 
    </div>
    
</div>
<div class="footer">
    <div class="legalInfo">
        INFORMACIÓN CONFIDENCIAL - SECRETO MÉDICO - ALCANCES DEL ARTÍCULO 156 DEL CÓDIGO PENAL
    </div>
    <div class="firmaLab">
        <div class="doctor">
            <?php echo nl2br($laboratorio->director_nombre); ?>
        </div>
        <div class="doctorTitulo">
                <?php echo nl2br($laboratorio->director_titulo); ?>
        </div>
        <div class="doctorMatricula">
            <?php echo nl2br($laboratorio->director_matricula); ?>
        </div>
    </div>
</div>
<hr>