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


<hr>

<div class="pagina">
    <div class="header_pap">
        <table>
            <tr>
                <td width="400px" style="font-size: 15px; padding-top: 0px; padding-left: 20px; float: left;">
                    <table class="header_pap">
                        <tr>
                           <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">PACIENTE </td><td style="font-size: 16px;" ><?php echo $modelp->pacienteTexto; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">DOCUMENTO </td><td style="font-size: 16px;" ><?php echo $modelp->pacienteDoc; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;" >EDAD </td><td style="font-size: 16px;" ><?php echo $model->edad; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">COBERTURA </td><td style="font-size: 16px;" ><?php echo $modelp->cobertura; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="400px" style="padding-top: 0px; margin-left: 20px; float: right; font-size: 16px;">
                    <table class="header_pap">
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold; font-size: 16px;">PROTOCOLO</td><td style="font-size: 16px;" ><?php echo $modelp->codigo; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;font-size: 16px;">FECHA</td><td style="font-size: 16px;" ><?php echo $modelp->fechaEntregaformateada; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;font-size: 16px;">MÉDICO </td><td style="font-size: 16px;" ><?php echo $modelp->medico->nombre; ?> </td>
                        </tr>
                        <tr>
                            <td style="white-space:nowrap; width: 3cm; font-weight: bold;font-size: 16px;">PROCEDENCIA </td><td style="font-size: 16px;" ><?php echo $modelp->procedencia->descripcion; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <h5 style="font-size: 15px; text-align: center; margin-left: 20px; font-weight: bold; text-decoration: underline">
        <?php echo $model->titulo; ?>
    </h5>
    <div class="informe">
        <div class="pap_labels" style=" text-decoration: underline;">
            MATERIAL
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->material); ?>
        </div>
        <div class="pap_labels"  style=" text-decoration: underline;">
            TECNICA
        </div>    
        <div class="pap_desc">
            <?php echo nl2br($model->tecnica); ?>
        </div>        
        <div class="pap_labels"  style=" text-decoration: underline;">
            CITOLOGÍA HORMONAL
        </div>  
        <div class="pap_desc">
            <table class="pap_desc">
                <?php
                    $calidad="";
                    $aspecto="";
                    $flora="";
                    $leucositos="";
                    $hematies="";
                    $otros="";
                    $microorganismos="";
                    if($model->calidad){
                        if(!empty( Leyenda::findOne(['codigo' => $model->calidad, 'categoria' => 'C' ]) ) ){
                            $calidad= Leyenda::findOne(['codigo' => $model->calidad, 'categoria' => 'C' ])->texto;
                        }
                    }
                    if($model->aspecto){
                        if(!empty( Leyenda::findOne(['codigo' => $model->aspecto , 'categoria' => 'A' ] ))){
                            $aspecto=Leyenda::findOne(['codigo' => $model->aspecto , 'categoria' => 'A' ] )->texto;
                        }
                    }
                    if($model->flora){
                        if(!empty( Leyenda::findOne(['codigo' => $model->flora, 'categoria' => 'F' ]) )){
                            $flora=Leyenda::findOne(['codigo' => $model->flora, 'categoria' => 'F' ])->texto;
                        }
                    }
                    if($model->leucositos){
                        if(!empty(Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->leucositos]))){
                            $leucositos=Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->leucositos])->texto;
                        }
                    }
                    if($model->hematies){
                        if(!empty(Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->hematies]))){
                            $hematies=Leyenda::findOne(['categoria' => 'LH','codigo'=> $model->hematies])->texto;
                        }
                    }
                    if($model->otros){
                        if(!empty(Leyenda::findOne(['codigo' => $model->otros , 'categoria' => 'O' ])) ){
                            $otros=Leyenda::findOne(['codigo' => $model->otros , 'categoria' => 'O' ])->texto;
                        }
                    }
                    if($model->microorganismos){
                        if(!empty(Leyenda::findOne(['codigo' => $model->microorganismos, 'categoria' => 'M' ])->texto) ){
                            $microorganismos=Leyenda::findOne(['codigo' => $model->microorganismos, 'categoria' => 'M' ])->texto;
                        }
                    }
                ?>
                <tr><td class="pap_labels_cito">CALIDAD DE MUESTRA</td> <td  class="pap_desc_cito"><?php echo $calidad          ?></td></tr>
                <tr><td class="pap_labels_cito">ASPECTO</td>            <td  class="pap_desc_cito"><?php echo $aspecto          ?></td></tr>
                <tr><td class="pap_labels_cito">FLORA</td>              <td  class="pap_desc_cito"><?php echo $flora            ?></td></tr>
                <tr><td class="pap_labels_cito">LEUCOCITOS</td>         <td  class="pap_desc_cito"><?php echo $leucositos       ?></td></tr>
                <tr><td class="pap_labels_cito">HEMATIES</td>           <td  class="pap_desc_cito"><?php echo $hematies         ?></td></tr>
                <tr><td class="pap_labels_cito">OTROS ELEMENTOS</td>    <td  class="pap_desc_cito"><?php echo $otros            ?></td></tr>
                <tr><td class="pap_labels_cito">MICROORGANISMOS</td>    <td  class="pap_desc_cito"><?php echo $microorganismos  ?></td></tr>
            </table>
            
        </div>
        <div class="pap_labels"  style=" text-decoration: underline;">
            CITOLOGÍA ONCOLÓGICA
        </div>
        <div class="pap_desc">
            <?php echo nl2br($model->citologia); ?>
        </div>
        <div class="pap_labels"  style=" text-decoration: underline;">
            DIAGNÓSTICO
        </div> 
        <div class="pap_desc">
            <?php echo nl2br($model->diagnostico);  ?>
        </div>
        <div class="pap_labels"  style=" text-decoration: underline;">
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
</body>     
</html>