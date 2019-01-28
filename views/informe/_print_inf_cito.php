<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>

<table >
    <tr  style="float: left">
    <tr>
        <td  width="400px">
            <?php if (!empty($laboratorio->web_path)){ ?>
                <img src="<?php echo Yii::getAlias('@webroot').$laboratorio->web_path; ?>" width="170"  \/>
            <?php } ?>
        </td>

        <td width="400px" style="float: left; padding-top: 40px">
            <?php if (!empty($laboratorio->leyenda_informe)){ ?>
                <div class="row"> <?php echo  $laboratorio->leyenda_informe ?></div>
            <?php } ?>
        </td>
    </tr>
    </tr>
</table>

<hr>
<div class="pagina">
    <div class="header_pap">
        <table>
            <tr>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td width="400px" style="padding-left: 20px; padding-top: 0px;float: left;">
                    <table class="header_pap">
                        <tr>
                           <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">PACIENTE </td><td style="font-size: 16px;" ><?php echo $modelp->pacienteTexto; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">DOCUMENTO </td><td style="font-size: 16px;" ><?php echo $modelp->pacienteDoc; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">EDAD </td><td style="font-size: 16px;" ><?php echo $model->edad; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">COBERTURA </td><td style="font-size: 16px;" ><?php echo $modelp->cobertura; ?> </td>
                        </tr>
                    </table>
                </td>
                <td width="400px" style="padding-top: 0px; margin-left: 20px; float: right;">
                    <table class="header_pap">
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">PROTOCOLO</td><td style="font-size: 16px;" ><?php echo $modelp->codigo; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">FECHA</td><td style="font-size: 16px;" ><?php echo $modelp->fechaEntregaformateada;  ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">MÉDICO </td><td style="font-size: 16px;" ><?php echo $modelp->medico->nombre; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">PROCEDENCIA </td><td style="font-size: 16px;" ><?php echo $modelp->procedencia->descripcion; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <h5 style="font-size: 13px;text-align: center; margin-left: 20px; font-weight: bold; text-decoration: underline">ESTUDIO DE CITOLOGIA ESPECIAL</h5>
    <div class="informe">
        <div class="pap_labels" style="text-decoration: underline;">
            TIPO DE ESTUDIO
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->tipo); ?>
        </div>
        <div class="pap_labels" style="text-decoration: underline;">
            MATERIAL
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->material); ?>
            <br><br>
            <?php echo nl2br($model->tecnica); ?>
        </div>     
        <div class="pap_labels" style="text-decoration: underline;">
            
            DESCRIPCION CITOLOGICA
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->descripcion);  ?>
        </div>
        <div class="pap_labels" style="text-decoration: underline;">
            DIAGNÓSTICO
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->diagnostico);  ?>
        </div>
        <div class="pap_labels" style="text-decoration: underline;">
            OBSERVACIONES
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->observaciones); ?>
        </div>
    </div>
    <div style="position: fixed; margin-right: 35px; text-align: right;">
        <?php
            if (!empty($laboratorio->web_path_firma)){
                ?>
                <img src="<?php echo Yii::getAlias('@webroot').$laboratorio->web_path_firma; ?>" width="120"  \/>
                <?php
            }
        ?>
    </div>


    
</div>


<div class="footer" style="position: fixed; bottom: -5px; text-align: center; font-size: 11px; width:100%">
    INFORMACIÓN CONFIDENCIAL - SECRETO MÉDICO - ALCANCES DEL ARTÍCULO 156 DEL CÓDIGO PENAL
</div>
    