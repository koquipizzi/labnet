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

                                        <h3 class="timeline-header" ><a data-toggle="tooltip" title="<?= $diagnosticoCompleto ?>"  href="#"><?= $estudio->nombre;  ?></a> 
                                        </h3>
                                        <div class="timeline-body">
                                            <?= $diagnosticoAcortado ?>
                                       
                                        <?php
                                            $this->registerCss(".popover-lg {min-width:620px; font-size: .9em;};
                                                                #popNomenclador {
                                                                    max-width: 200px;
                                                                    padding-right: 1px;
                                                                }
                                                                ");

                                       /* if (isset($historial['fecha_entrega']))
                                            {
                                                $date = date_create($historial['fecha_entrega']);
                                                $fecha= date_format($date, 'd-m-Y');
                                                list($mes, $día, $año) = explode("-", $fecha);
                                            //    echo $mes."-".$día."-".$año ;
                                            }
                                            */
                                            $id_i=$historial['id_informe'];
                                            $modelI= Informe::find()->where("id=$id_i")->one();
                                            if($modelI->Estudio_id===Estudio::getEstudioPap()){
                                                $content= DetailView::widget([
                                                    'model' => $modelI,
                                                    'attributes' =>
                                                    [
                                                    'material',
                                                    [
                                                        'label'=>'Calidad', 
                                                         'value' => empty($modelI->calidad) ? "" : Leyenda::findOne(['id' => $modelI->calidad ])->texto ,
                                                    ],
                                                    [
                                                        'label'=>'Aspecto',
                                                       //  'value' => empty($modelI->aspecto) ? Leyenda::findOne(['id' => $modelI->aspecto ])->texto: "",
                                                        'value' => empty($modelI->aspecto) ? "": Leyenda::findOne(['id' => $modelI->aspecto ])->texto,
                                                    ],
                                                    [
                                                        'label'=>'Flora',
                                                        'value'=> empty($modelI->flora) ? "" : Leyenda::findOne(['id' => $modelI->flora ])->texto,
                                                        
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
                                                        'value'=>  empty($modelI->otros) ? "": Leyenda::findOne(['id' => $modelI->otros ])->texto,
                                                    ],
                                                  /*  [
                                                        'label'=>'Microorganismos',
                                                        'value'=> empty($modelI->microorganismos) ? Leyenda::findOne(['id' => $modelI->microorganismos ])->texto: "",
                                                    ],*/
                         
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
                                              //      'tipo',
                                                    'material',
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
                                       // 'tipo',
                                        'material',
                                        'descripcion',
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
                                     //       'tipo',
                                            'material',
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
                                

  
        
    
    