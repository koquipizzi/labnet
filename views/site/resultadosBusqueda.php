<?php
    
    use yii\helpers\Html;
    use yii\grid\GridView;
    use kartik\datecontrol\DateControl;
    use yii\widgets\Pjax;
    use yii\helpers\Url;
    use app\models\Estudio;
    
    if (!empty($resultados))
        echo "<h4> Resultados de la busqueda de : <strong> $field <strong> </h4>";
    else
        echo "<h4> No se encontraron Resultados para : <strong> $field <strong> </h4>";
?>

<section id="page-content">
    <div class="body-content animated fadeIn" >
        <div class="panel_titulo">
            <div class="panel-heading ">
            </div>
                <div class="box-body">
                <?php
                    $cont = 1;
                    foreach ($resultados as $resultado){
                        
                        if ($cont % 2){
                            echo "<div class=\"row\">";
                        }
                            echo "<div class='col-xs-6'>";
                        
                        if ($resultado->className() === "app\models\Paciente") {
                ?>
                            <div class="box box-info box-header search_strong" style="padding-top: 0px" >
                                <div class="">
                                    <h3 style="margin-top: 10px"><?php echo Html::a("Paciente: $resultado->nombre", Url::to(['paciente/view' , 'id'=> $resultado->id ]))?></h3>
                                </div>
                                           <?php
                                                if (!empty($resultado->nro_documento))
                                                    echo "<strong> Nro de Documento: </strong>   $resultado->nro_documento <br>";
                                                if (!empty($resultado->fecha_nacimiento)){
                                                    $fecha = new \DateTime($resultado->fecha_nacimiento);
                                                    $fechaNacimiento = $fecha->format('d/m/y');
                                                    echo "<strong>Fecha de Nacimiento: </strong> $fechaNacimiento <br>";
                                                }
                                                if (!empty($resultado->email))
                                                    echo "<strong> Email: </strong>   $resultado->email <br>";
                                                if (!empty($resultado->telefono))
                                                    echo "<strong> Telefono: </strong> $resultado->telefono <br>";
                                           ?>
                            </div>
                <?php
                        }else if ($resultado->className() === "app\models\Medico") {
                ?>
                            <div class="box box-info box-header search_strong" style="padding-top: 0px" >
                                <div class="">
                                    <h3 style="margin-top: 10px"><?php echo Html::a("Medico : $resultado->nombre", Url::to(['medico/view' , 'id'=> $resultado->id ]))?></h3>
                                </div>
                                <?php
                                    if (!empty($resultado->email))
                                        echo "<strong>  Email: </strong>   $resultado->email <br>";
                                    if (!empty($resultado->telefono))
                                        echo "<strong>  Telefono: </strong> $resultado->telefono <br>";
                                ?>
                            </div>
                <?php
                        }else if ($resultado->className() === "app\models\Protocolo") {
                ?>
                            <div class="box box-info box-header search_strong" style="padding-top: 0px" >
                                <div class="">
                                    <h3 style="margin-top: 10px"><?php echo Html::a("Protocolo: $resultado->codigo", Url::to(['protocolo/view' , 'id'=> $resultado->id ]))?></h3>
                                </div>
                                <p><?php echo $resultado->observaciones  ?></p>
                            </div>
                <?php } ?>
                            
                <?php
                        echo '</div>';
                        $cont = $cont+1;
                        if ($cont % 2) {
                            echo '</div>';
                        }
                        
                        
                        
                } ?>
                
                <div class="clearfix"></div>
            </div>
            
            <?php   if (!empty($resultados)){ ?>
                        <div class="pull-right">
                            <button id="goBack" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Anterior </button>
                            <button id="goFoward" class="btn btn-primary">Siguiente <i class="fa fa-arrow-right"></i> </button>
                        </div>
            <?php   } ?>
            <div class="clearfix"></div>
        </div>
    </div>
</section>




