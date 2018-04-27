<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use yii\helpers\Url;
/*    use yii\helpers\ArrayHelper;*/
    /* @var $this yii\web\View */
    /* @var $searchModel app\models\ResponsableSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */
    
    $this->title = Yii::t('app', 'Buscador');
    $this->params['breadcrumbs'][] = $this->title;
?>
<section id="page-content">
    <div class="body-content animated fadeIn" >
        <div class="panel_titulo">
            <div class="panel-heading ">
                <?php
                    if (!empty($resultados))
                        echo "<h4> Resultados de la busqueda de : <strong> $field <strong> </h4>";
                    else
                        echo "<h4> No se encontraron Resultados para : <strong> $field <strong> </h4>";
                ?>
                <div class="pull-right">
                </div>
                <?php
                    foreach ($resultados as $resultado){
                        if ($resultado->className() === "app\models\Paciente") {
                ?>
                            <div class="box box-info box-header search_strong" style="padding-top: 0px" >
                                <div class="">
                                    <h3 style="margin-top: 10px"><?php echo Html::a("Paciente: $resultado->nombre", Url::to(['paciente/view' , 'id'=> $resultado->id ]))?></h3>
                                </div>
                                           <?php
                                                if (!empty($resultado->nro_documento))
                                                    echo "<strong> Nro de Documento: </strong>   $resultado->nro_documento";
                                                if (!empty($resultado->fecha_nacimiento))
                                                    echo "<strong> - Fecha de Nacimiento: </strong> $resultado->fecha_nacimiento";
                                                if (!empty($resultado->email))
                                                    echo "<strong> - Email: </strong>   $resultado->email";
                                                if (!empty($resultado->telefono))
                                                    echo "<strong> - Telefono: </strong> $resultado->telefono";
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
                                        echo "<strong> - Email: </strong>   $resultado->email";
                                    if (!empty($resultado->telefono))
                                        echo "<strong> - Telefono: </strong> $resultado->telefono";
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
                <?php
                        }
                    }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>


