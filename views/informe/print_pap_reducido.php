<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>
<div class="pagina">
    <div class="header_pap">     
   <div class="ContainerDataProtocolo">
            <div class="ContainerLab">
                CIPAT
            </div>  
            <div class="ContainerDataFecha">
                 <?php echo $modelp->fechaEntrega; ?>
            </div>   
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
            <div   class="ContainerDataEdad">
                <div class="labelprotocoloEdad"  >
                    Edad:
                </div>
                <div class="descriptionProtocoloEdad"  >
                           <?php echo $model->edad; ?>
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
        <div class="contenedorInformePap">   
                 <div class="labeInformePap">   
                   CALIDAD DE MUESTRA
                  </div>    
                 <div class="camposInformePap">
                      <?php echo $model->calidad ? Leyenda::findOne(['id' => $model->calidad ])->texto : ""  ?>
                 </div>     
       </div> 
        <div class="contenedorInformePap">   
                 <div class="labeInformePap">   
                   ASPECTO
                  </div>    
                 <div class="camposInformePap">
                     <?php echo $model->aspecto ? Leyenda::findOne(['id' => $model->aspecto ])->texto : ""  ?>
                 </div>     
       </div>     
        <div class="contenedorInformePap">   
                 <div class="labeInformePap">   
                   FLORA
                  </div>    
                 <div class="camposInformePap">
                   <?php echo $model->flora ? Leyenda::findOne(['id' => $model->flora ])->texto : ""  ?>
                 </div>     
       </div>        
        <div class="contenedorInformePap">   
                <div class="labeInformePap">   
                   LEUCOCITOS
                </div>    
                <div class="camposInformePap">
                   <?php echo Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->leucositos])->texto  ?>
                </div>     
       </div>
        <div class="contenedorInformePap">   
                 <div class="labeInformePap">   
                   HEMATIES
                  </div>    
                 <div class="camposInformePap">
                   <?php echo Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->hematies])->texto ?>
                 </div>     
        </div>           
        <div class="contenedorInformePap">   
                 <div class="labeInformePap">   
                   OTROS ELEMENTOS
                  </div>    
                 <div class="camposInformePap">
                   <?php echo $model->otros ? Leyenda::findOne(['id' => $model->otros ])->texto : ""  ?>
                 </div>     
       </div>         
        <div class="contenedorInformePap">   
                 <div class="labeInformePap">   
                   MICROORGANISMOS
                  </div>    
                 <div class="camposInformePap">
                   <?php echo $model->microorganismos ? Leyenda::findOne(['id' => $model->microorganismos ])->texto : ""  ?>
                 </div>     
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