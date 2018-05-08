<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>
<html>
<body>


<table >
    <tr  style="float: left">
    <tr>
        <td  width="400px">
            <?php if (!empty($laboratorio->web_path)){ ?>
                <img src="<?php echo Yii::getAlias('@webroot').$laboratorio->web_path; ?>" width="170"  \/>
            <?php } ?>
        </td>

        <td width="300px" style="float: left; padding-top: 40px">
            <?php if (!empty($laboratorio->leyenda_informe)){ ?>
                <div class="row"> <?php echo  $laboratorio->leyenda_informe ?></div>
            <?php } ?>
        </td>
    </tr>
    </tr>
</table>

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
                           <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PACIENTE </td><td><?php echo $modelp->pacienteTexto; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">DOCUMENTO </td><td><?php echo $modelp->pacienteDoc; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">EDAD </td><td><?php echo $model->edad; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">COBERTURA </td><td><?php echo $modelp->cobertura; ?> </td>
                        </tr>
                    </table>
                </td>
                <td width="400px" style="padding-top: 0px; margin-left: 20px; float: right;">
                    <table class="header_pap">
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PROTOCOLO</td><td><?php echo $modelp->codigo; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">FECHA</td><td><?php echo $modelp->fechaEntrega;  ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">MÉDICO </td><td><?php echo $modelp->medico->nombre; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PROCEDENCIA </td><td><?php echo $modelp->procedencia->descripcion; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <h5 style="font-size:13px; text-align: center; margin-left: 20px; font-weight: bold; text-decoration: underline">INFORME INMUNOHISTOQUÍMICO</h5>
    <div class="informe">
        <div class="pap_labels" style="text-decoration: underline;">
            MATERIAL
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->material); ?>
            <br><br>
            <?php echo nl2br($model->tecnica); ?>
        </div>        
        <div class="pap_labels" style="text-decoration: underline;">
            MACROSCOPÍA
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->macroscopia)  ?>
        </div>
        <div class="pap_labels" style="text-decoration: underline;">
            MICROSCOPÍA
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->microscopia) ?>
        </div>
        <div class="pap_labels" style="text-decoration: underline;">
            DIAGNÓSTICO
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->diagnostico)  ?>
        </div>
        <div class="pap_labels" style="text-decoration: underline;">
            OBSERVACIONES
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->observaciones)  ?>
        </div>
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



<div class="footer" style="position: fixed; bottom: -5px; text-align: center; font-size: 11px; width:100%">
    INFORMACIÓN CONFIDENCIAL - SECRETO MÉDICO - ALCANCES DEL ARTÍCULO 156 DEL CÓDIGO PENAL
</div>
    
</body> 
</html>