<!-- Start recent activity item -->

<?php
use app\models\Estudio;
use app\models\Informe;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use kartik\popover\PopoverX;

use app\assets\admin\dashboard\DashboardAsset;
DashboardAsset::register($this);

?> 

    <div class="panel-body no-padding">
        <?php 
            $estudios_label = array( 
                            "1" => "danger", 
                            "2" => "warning", 
                            "3" => "success",
                            "4" => "primary",  
                            "5" => "info",  
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
                                    height: 400px;}");
            ?>
            <div data-toggle="tooltip" data-placement="top" title=" <?php echo 'Diagnóstico: '. $diagnosticoCompleto?>" class="lx-tooltip">
                        <div class="recent-activity-item 
                            <?php 
                                $estudio_id= $historial['Estudio_id'];
                                $estudio = Estudio::find()->where("id=$estudio_id")->one(); 
                                echo "recent-activity-".$estudios_label[$estudio->id];
                                
                                if(++$i === $numItems) {
                                        echo " recent-activity-last";
                                } 
                            ?> ">
                            <div class="recent-activity-badge">
                                <span class="recent-activity-badge-userpic"></span>
                            </div>
                            <div class="recent-activity-body">
                                <div class="recent-activity-body-head">
                                    <div class="recent-activity-body-head-caption">
                                        <h3 class="recent-activity-body-title">
                                        <?= $estudio->nombre;  ?>
                                        </h3>
                                    </div>

                                </div>
                                <div class="recent-activity-body-content">
                                    <p>  Diagnóstico: 
                                     <?php 
                                        echo $diagnosticoAcortado; 
                                        echo "<span class='text-block text-muted'>";
                                        if (isset($historial['fecha_fin']))
                                            {
                                           $date = date_create($historial['fecha_fin']);
                                          $fecha= date_format($date, 'd-m-Y');
                                           list($mes, $día, $año) = explode("-", $fecha);
                                            echo $mes."-".$día."-".$año ;
                                                
                                            }
                                        
                                        $id_i=$historial['id_informe'];
                                        $modelI= Informe::find()->where("id=$id_i")->one();                                              
                                        if($modelI->Estudio_id===Estudio::getEstudioPap()){
                                            $content= DetailView::widget([
                                                            'model' => $modelI,
                                                            'attributes' =>
                                                            [
                                                                'material',
                                                               // 'descripcion',
                                                                'calidad',
                                                                'aspecto',
                                                                'flora',
                                                                'leucositos',
                                                                'hematies',
                                                                'otros',
                                                                'microorganismos',                                                                
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
                                                                'tipo',
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
                                        
                                       // right
                                        $this->registerCss(".popover-lg {min-width:600px; font-size: .8em;}");
                                        echo PopoverX::widget([
                                                                'header' => 'Detalle del Informe',
                                                                        'placement' => PopoverX::ALIGN_RIGHT,
                                                                        'size' => PopoverX::SIZE_LARGE,
                                                                'content' => $content ,
                                                                'toggleButton' => ['label'=> 'ver','style'=> 'margin-left: 1em;', 'class'=>'btn btn-teal btn-xs ' ],
                                                             ]);
                                        echo "</span>";
                                       ?>

                                    </p>
                                </div>
                        </div>
                    </div>    
                </div>
        <?php }?>
         <!-- End recent activity item -->
    </div>
                                

  
        
    
    