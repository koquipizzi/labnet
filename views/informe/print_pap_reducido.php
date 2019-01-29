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
        <?php echo $model->titulo; ?>
    </div>
    <div class="informe">
        <div class="contenedorInformePap">   
            <div class="labeInformePap">
                MATERIAL
            </div>    
            <div class="camposInformePap">
                <?php echo nl2br($model->material); ?>
            </div>
        </div> 
        <div class="contenedorInformePap">   
            <div class="labeInformePap">   
            TÉCNICA
            </div>    
            <div class="camposInformePap">
                <?php echo nl2br($model->tecnica); ?>
            </div>     
       </div>                
        <div class="pap_labels">
            CITOLOGÍA HORMONAL
        </div>   
       
        <div class="pap_desc">
            <table class="pap_desc">
                <tr><td class="pap_labels_combo">CALIDAD DE MUESTRA</td> <td  class="pap_desc_combo"><?php echo $model->calidad ? Leyenda::findOne(['codigo' => $model->calidad, 'categoria' => 'C' ])->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_combo">ASPECTO</td>            <td  class="pap_desc_combo"><?php echo $model->aspecto ? Leyenda::findOne(['codigo' => $model->aspecto , 'categoria' => 'A' ] )->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_combo">FLORA</td>              <td  class="pap_desc_combo"><?php echo $model->flora ? Leyenda::findOne(['codigo' => $model->flora, 'categoria' => 'F' ])->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_combo">LEUCOCITOS</td>         <td  class="pap_desc_combo"><?php echo $model->leucositos ? Leyenda::findOne(['categoria' => 'LH','codigo'=>  $model->leucositos])->texto : "No se observan."?></td></tr>
                <tr><td class="pap_labels_combo">HEMATIES</td>           <td  class="pap_desc_combo"><?php echo $model->hematies ? Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->hematies])->texto : "No se observan." ?></td></tr>
                <tr><td class="pap_labels_combo">OTROS ELEMENTOS</td>    <td  class="pap_desc_combo"><?php echo $model->otros ? Leyenda::findOne(['codigo' => $model->otros , 'categoria' => 'O' ])->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_combo">MICROORGANISMOS</td>    <td  class="pap_desc_combo"><?php echo $model->microorganismos ? Leyenda::findOne(['codigo' => $model->microorganismos, 'categoria' => 'M' ])->texto : ""  ?></td></tr>
            </table>
            
        </div>                 
        <div class="contenedorInformePap">   
            <div class="labeInformePap">   
                CITOLOGÍA ONCOLÓGICA
            </div>    
            <div class="camposInformePap">
                <?php echo nl2br($model->citologia); ?>
            </div>     
       </div>          
        <div class="contenedorInformePap">   
            <div class="labeInformePap">   
                DIAGNÓSTICO
            </div> 
            <div class="camposInformePap">
                <?php echo nl2br($model->diagnostico);  ?>
            </div>     
       </div>  
        <div class="contenedorInformePap">   
            <div class="labeInformePap">   
                OBSERVACIONES
            </div>
            <div class="camposInformePap">
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