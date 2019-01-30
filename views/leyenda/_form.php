<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Localidad */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
$js = '
$("#leyenda-codigo").change(function(){
    setTimeout(function(){ existeCodigo(); }, 500);  
}); 
$("#leyenda-categoria").change(function(){
    setTimeout(function(){ existeCodigo(); }, 500);  
}); 
function existeCodigo(){
    var codigo = $("#leyenda-codigo").val();   
    var leyenda_id = $("[name=leyenda_id]").val();   
    console.log("let"+leyenda_id);
    var categoria = $("#leyenda-categoria").select2("data")[0].id;
    if(categoria!==undefined && categoria!=""){
        $.ajax({
            url    : "index.php?r=leyenda/existe-codigo",
            type   : "post",
            data   : {
                codigo: codigo,
                categoria: categoria,
                leyenda_id: leyenda_id,
            },
            success: function (response) 
            {                             
                if(response.rta===false){
                    $("#create-legend").yiiActiveForm("updateAttribute", "leyenda-codigo","");    
                    $(".allowSend").prop("disabled", false);                                 
                }   
                if(response.rta===true){                    
                    $("#create-legend").yiiActiveForm("updateMessages", {
                        "leyenda-codigo": [response.messageUser]
                    }, true);   
                    $(".allowSend").prop("disabled", true);
                }                                                         
            }               
        });
    }

 } 
 ';
 $this->registerJs($js);

?>
    <div class="panel-body no-padding">
        <?php 
        $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-legend',  
                ]
        ]);
        ?>
          <?=  Html::hiddenInput('leyenda_id', $model->id); 
        ?>
        <?= $form->field($model, 'codigo', ['template' => "{label}
                <div class='col-md-4'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
            ])->textInput(['maxlength' => true]) 
        ?>
        <?= $form->field($model, 'texto', ['template' => "{label}
                <div class='col-md-4'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
            ])->textInput(['maxlength' => true]) 
        ?>
        <?php    
            if($model->isNewRecord){
                $dataLeyendaCategoria = ArrayHelper::map(app\models\LeyendaCategoria::find()->asArray()->all(), 'id', 'descripcion');           
            }else{
                $dataLeyendaCategoria = ArrayHelper::map(app\models\LeyendaCategoria::find()->asArray()->all(), 'id', 'descripcion');                      
                $dataSelected = ArrayHelper::map(app\models\LeyendaCategoria::find()->where(["id"=>$model->categoria])->asArray()->all(), 'id', 'descripcion');                              
                array_merge($dataSelected,$dataLeyendaCategoria);
            }          
            echo $form->field($model, 'categoria', ['template' => "{label}
            <div class='col-md-4'>{input}</div>
            {hint}{error}",  'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
            ])->widget(Select2::classname(),
                [
                    'data' => $dataLeyendaCategoria,          
                    'language' => 'es',
                    'options' => [  
                        'placeholder' => 'Seleccione una Leyenda ...',
                    ],
                    
                ])->error([ 'style' => ' margin-left: 35%;']);;
        ?>
        <div class="box-footer">
            <div style="text-align: right;">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success allowSend' : 'allowSend btn btn-primary']) ?>
            <button type="reset" class="btn btn-danger">Restablecer</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
