<!-- Start recent activity item -->

<?php
use app\models\Estudio;
use app\models\Informe;
use app\models\Leyenda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use kartik\popover\PopoverX;

?> 
    <div class="panel-body no-padding">
        <ul class="timeline">
    
        <?php 
            $estudios_label = array( 
                            "1" => "maroon", 
                            "2" => "aqua", 
                            "3" => "yellow",
                            "4" => "purple",  
                            "5" => "blue",  
                        );
            $numItems = count($historialPaciente);
            $i = 0;
            
            //var_dump($historialPaciente); die();
            foreach ($historialPaciente as $historial){
                if(is_array($historial) && array_key_exists("id_informe",$historial) && !empty($historial['id_informe'])){
                    $id_i=$historial['id_informe'];
                    $modelI= Informe::find()->where(["id"=>$id_i])->one();
                }

                if( strlen($historial['diagnostico'])>0){
                        
                        $diagnosticoAcortado=substr( $historial['diagnostico'],0,50)."...";
                        $diagnosticoCompleto= $historial['diagnostico'];
                }else{
                        $diagnosticoAcortado='No tiene diagnóstico';
                        $diagnosticoCompleto= 'No tiene diagnóstico';
                        }

            $this->registerCss(".lx-tooltip + .tooltip > .tooltip-inner {min-width: 500px; text-align: left; z-index:3000;}");
            $this->registerCss("#historialPacientePanel {
                                    float:left;
                                    width:100%;
                                    overflow-y: auto;
                                    background-color: white;
                                    height: 400px;}");
            ?>     
                            <?php 
                                $estudio_id= $historial['Estudio_id'];
                                $estudio = Estudio::find()->where("id=$estudio_id")->one(); 
                            ?> 
                            
                                <li>
                                    <i class="fa fa-file-o bg-<?= $estudios_label[$estudio->id] ?>"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-calendar-check-o"></i>
                                            <?php 
                                                if (isset($historial['fecha_entrega']))
                                                {
                                                $date = date_create($historial['fecha_entrega']);
                                                $fecha= date_format($date, 'd-m-y');
                                                list($mes, $día, $año) = explode("-", $fecha);
                                                echo $mes."-".$día."-".$año ;    
                                                }
                                            ?>
                                        </span>

                                        <h3 class="timeline-header" ><a data-toggle="tooltip" title="<?= $diagnosticoCompleto ?>" ><?= $estudio->nombre;  ?></a>
                                        </h3>
                                        <div class="timeline-body">
                                        <?= (!empty($modelI->protocolo) && !empty($modelI->codigoProtocolo) ) ? "Protocolo: "."<a  href='index.php?r=protocolo/update&id= {$modelI->protocolo->id}'>{$modelI->codigoProtocolo}</a>" : "" ;?>                                       
                                        <?php
                                            $this->registerCss(".popover-lg {min-width:620px; font-size: .9em;};
                                                                    #popNomenclador {
                                                                        max-width: 200px;
                                                                        padding-right: 1px;
                                                                    }
                                                                ");                            
                                        
                                            if (empty($modelI->aspecto))
                                                $aspecto2 = "Sin datos";
                                            else
                                               {// $aspecto = Leyenda::find()->where(['=', 'id', $modelI->aspecto])->one(); 
                                                $aspecto = Leyenda::find()->where("codigo='{$modelI->aspecto}'")->one();
                                                   Leyenda::find()->where(['=', 'id', $modelI->calidad])->one();
                                                   if(!empty($aspecto)){
                                                       $aspecto2 = $aspecto->texto;
                                                   }else {
                                                       $aspecto2 ='';
                                                   }
                                            }
                                               
                                           if (empty($modelI->calidad))
                                                $calidad = "Sin datos"; 
                                            else
                                               {$c = Leyenda::find()->where("codigo='{$modelI->calidad}'")->one();
                                                   if(!empty($c)){
                                                       $calidad = $c->texto;
                                                   }else{
                                                       $calidad ='';
                                                   }
                                               }
                                                              
                                            if (empty($modelI->flora))
                                                $flora = "Sin datos"; 
                                            else
                                               { $f = Leyenda::find()->where("codigo='{$modelI->flora}'")->one();
                                                   if(!empty($f )){
                                                       $flora = $f->texto;
                                                   }else {
                                                       $flora = '';
                                                   }
                                               } 
                                               
                                            if (empty($modelI->otros))
                                               $otros = "Sin datos"; 
                                            else
                                              { $o = Leyenda::find()->where("codigo='{$modelI->otros}'")->one();
                                                  if(!empty($o)){
                                                      $otros = $o->texto;
                                                  }else {
                                                      $otros ='';
                                                  }
                                              }

                                            if (empty($modelI->microorganismos))
                                              $microorganismos = "Sin datos"; 
                                            else
                                                {   $m = Leyenda::find()->where("codigo='{$modelI->microorganismos}'")->one();
                                                    if(!empty($m)){
                                                        $microorganismos = $m->texto;
                                                    }else {
                                                        $microorganismos ='';
                                                    }
                                                } 

                                            if (!empty($modelI->citologia)){                                            
                                                $citologia = $modelI->citologia;
                                            }else {
                                                $citologia ='';
                                            }                   

                                            if($modelI->Estudio_id===Estudio::getEstudioPap()){
                                                $content= 
                                                DetailView::widget([
                                                    'model' => $modelI,
                                                    'attributes' =>
                                                    [
                                                    'material',
                                                    [
                                                        'label'=>'Calidad', 
                                                        'value' => $calidad,
                                                    ],
                                                    [
                                                        'label'=>'Aspecto',
                                                        'value' => $aspecto2,
                                                    ],
                                                    [
                                                        'label'=>'Flora',
                                                        'value' => $flora,                           
                                                    ],
                                                    [
                                                        'label'=>'Leucocitos',
                                                        'value' => $modelI->getValor($modelI->leucositos) ,
                                                    ],
                                                    [
                                                        'label'=>'Hematíes',
                                                        'value'=>$modelI->getValor($modelI->hematies),
                                                    ],
                                                    [
                                                        'label'=>'Otros',
                                                        'value'=> $otros,
                                                    ],
                                                    [
                                                        'label'=>'Microorganismos',
                                                        'value'=>$microorganismos,
                                                    ],
                                                    [
                                                        'label'=>'Citología Oncológica',
                                                        'value'=>$citologia,
                                                    ],
                                                 
                                                    'diagnostico',
                                                    'observaciones',
                                               
                                                    ],
                                                ]);
                                                
                                            }
                                if($modelI->Estudio_id === Estudio::getEstudioCitologia()){
                                                $content= DetailView::widget([
                                                    'model' => $modelI,
                                                    'attributes' =>
                                                    [
                                                    'tipo',
                                                    'material',
                                                    'tecnica',
                                                    'descripcion',
                                                    'diagnostico',
                                                    'observaciones'
                                                    ],
                                                ]);
                                            }
                                if($modelI->Estudio_id === Estudio::getEstudioBiopsia()){
                                    $content= DetailView::widget([
                                        'model' => $modelI,
                                        'attributes' =>
                                        [
                                        'tipo',
                                        'material',
                                        'tecnica',
                                        'macroscopia', 
                                        'microscopia',
                                        'diagnostico',
                                        'observaciones'
                                        ],
                                    ]);
                                }
                                if($modelI->Estudio_id === Estudio::getEstudioMolecular()){
                                    $content= DetailView::widget([
                                        'model' => $modelI,
                                        'attributes' =>
                                        [
                                            'tipo',
                                            'material',
                                            'tecnica',
                                            'descripcion',
                                            'diagnostico',
                                            'observaciones'
                                        ],
                                    ]);
                                }
                                if($modelI->Estudio_id === Estudio::getEstudioInmuno()){
                                    $content= DetailView::widget([
                                        'model' => $modelI,
                                        'attributes' =>
                                        [
                                            'material',
                                            'macroscopia',
                                            'microscopia',
                                            'diagnostico',
                                            'observaciones'
                                        ],
                                        ]);
                                }
                               
                                echo PopoverX::widget([
                                                'header' => 'Detalle Estudio',
                                              //  'id'=>'popHistorial$id_i',
                                                'class' => 'popover-lg',
                                                'placement' => PopoverX::ALIGN_RIGHT,
                                                'content' => $content,        
                                                'toggleButton' => ['label'=>'Ver más', 'class'=>'btn btn-primary btn-xs'],
                                            ]);

                                              $this->registerCss(".popover.right {min-width:620px; font-size: .9em;};
                                                                #popNomenclador {
                                                                    max-width: 200px;
                                                                    padding-right: 1px;
                                                                }
                                                                ");
                                        ?>
                                       
                                         </div>
     
                                        <!--/div-->
                                    </div>
                                </li>
                                
                               <?php }?>
                               
                                <li>
                                    <i class="fa fa-folder-open bg-gray"></i>
                                </li>
                        
          </ul>
         <!-- End recent activity item -->
    </div>
                                

  
        
    
    