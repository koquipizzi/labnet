<?php
use app\models\Leyenda;
use yii\helpers\Html;
?>
<html>
<body> 


<div class="pagina">
    <div class="header_pap">       
        <table>
            <tr height="400" style="margin-top:100px;">
                <td>                    
                     
                </td>
            </tr>
            <tr>
                <td width="400px" style="padding-top: 180px; padding-left: 20px; float: left;">
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
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">COBERTURA </td><td><?php echo $modelp->cobertura; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="400px" style="padding-top: 180px; margin-left: 20px; float: right;">
                    <table class="header_pap">
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">PROTOCOLO</td><td><?php echo $modelp->codigo; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;">FECHA</td><td><?php echo $modelp->fechaEntrega; ?> </td>
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
    <h5 style="font-size: 13px; text-align: center; margin-left: 20px; font-weight: bold; text-decoration: underline">
        <?php echo $model->titulo; ?>
    </h5>
    <div class="informe">
        <div class="pap_labels">
            MATERIAL
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->material); ?>
        </div>
        <div class="pap_labels">
            TECNICA
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->tecnica); ?>
        </div>        
        <div class="pap_labels">
            CITOLOGÍA HORMONAL
        </div>  
        <div class="pap_desc">
            <table class="pap_desc">
                <tr><td class="pap_labels_cito">CALIDAD DE MUESTRA</td> <td  class="pap_desc_cito"><?php echo $model->calidad ? Leyenda::findOne(['codigo' => $model->calidad, 'categoria' => 'C' ])->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_cito">ASPECTO</td>            <td  class="pap_desc_cito"><?php echo $model->aspecto ? Leyenda::findOne(['codigo' => $model->aspecto , 'categoria' => 'A' ] )->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_cito">FLORA</td>              <td  class="pap_desc_cito"><?php echo $model->flora ? Leyenda::findOne(['codigo' => $model->flora, 'categoria' => 'F' ])->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_cito">LEUCOCITOS</td>         <td  class="pap_desc_cito"><?php echo $model->leucositos ? Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->leucositos])->texto : ""?></td></tr>
                <tr><td class="pap_labels_cito">HEMATIES</td>           <td  class="pap_desc_cito"><?php echo $model->hematies ? Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->hematies])->texto : "" ?></td></tr>
                <tr><td class="pap_labels_cito">OTROS ELEMENTOS</td>    <td  class="pap_desc_cito"><?php echo $model->otros ? Leyenda::findOne(['codigo' => $model->otros , 'categoria' => 'O' ])->texto : ""  ?></td></tr>
                <tr><td class="pap_labels_cito">MICROORGANISMOS</td>    <td  class="pap_desc_cito"><?php echo $model->microorganismos ? Leyenda::findOne(['codigo' => $model->microorganismos, 'categoria' => 'M' ])->texto : ""  ?></td></tr>
            </table>
            
        </div>
        <div class="pap_labels">
            CITOLOGÍA ONCOLÓGICA
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->citologia); ?>
        </div>
        <div class="pap_labels">
            DIAGNÓSTICO
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->diagnostico);  ?>
        </div>
        <div class="pap_labels">
            OBSERVACIONES
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->observaciones); ?>
        </div>
    </div>
    <div style="position: fixed; margin-right: 35px; text-align: right;">
        <img src="<?php echo Yii::getAlias('@webroot').'/images/firma/firma.jpg'; ?>" width="120"  \/>  
    </div>
</div>

<div class="footer" style="position: fixed; bottom: -5px; text-align: center; font-size: 11px; width:100%">
    INFORMACIÓN CONFIDENCIAL - SECRETO MÉDICO - ALCANCES DEL ARTÍCULO 156 DEL CÓDIGO PENAL
</div>
</body>     
</html>