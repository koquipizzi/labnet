<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

use yii\bootstrap\Modal;
//use yii\grid\GridView;
use kartik\grid\GridView;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;
//yii fue sustituido por
use kartik\select2\Select2;
//use vova07\select2\Widget;
use kartik\datecontrol\DateControl;
//Models
use app\models\Estudio;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use app\models\Medico;
use app\models\ViewPacientePrestadora;
use app\models\ViewPacientePrestadoraQuery;
use app\models\Prestadoras;
use app\models\InformeNomenclador;
use app\models\PacientePrestadora;
/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
if (!$session->isActive)
                // open a session
    $session->open();

$js = '




 $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {        
        var informeId= $(item).find(".id_informe_hidden").val();
        var btn=$(item).find(".remove-item");
         console.log(btn);
        var permitido;
        permitido=$( ".remove-item" ).hasClass( "permitidoBorrar" );
        if(permitido!=true){
            $.ajax({
                url    : "index.php?r=informe/fue-modificado",
                type   : "post",
                data   : {
                            "informeId":informeId,
                        },
                success: function (response)
                {
                    console.log(response);
                    console.log(response.rta);
                    if(response.rta=="ok"){
                       var n = noty
                            ({
                                text:   "El inofme no puede eliminarse debido a que el mismo ya ha sido modificado.",
                                type:   "error",
                                class:  "animated pulse",
                                layout: "topCenter",
                                theme:  "relax",
                                timeout: 3000, // delay for closing event. Set false for sticky notifications
                                force:  false, // adds notification to the beginning of queue when set to true
                                modal:  false, // si pongo true me hace el efecto de pantalla gris
                                // maxVisible : 10
                            });  
                    } 
                    if(response.rta=="error"){                     
                        $(btn).addClass( "permitidoBorrar" );
                        $(btn).click();

                    } 

                },
            });
        }
        if(permitido==true){
               return true;
        }
         return false;
    });







jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Estudio: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Estudio: " + (index + 1))
    });
});

//obtiene dinamicamente el nro de secuencia segun la letra ingresada
$( document ).ready(function() {

    $("body").on("beforeSubmit", "form#dynamic-form", function () {
        var form = $(this);
        var permitido=false;
        // console.log($(".field-protocolo-nro_secuencia").hasClass(".has-error"));
        if ($("#protocolo-id").hasClass("no-permitido-borrar")===false) {
            console.log("entre permitido");
            permitido= true;
        } 
        if ($("#protocolo-id").hasClass("no-permitido-borrar")===true) {
            numeroSecuenciaLetraUpdate();
        }
        if(permitido===true){
        return true;
        }    

        return false;
    });

    //cambia la letra a mayusculas en protocolo-letra
    $("#protocolo-letra").keyup(function(){
        this.value = this.value.toUpperCase();
    });

    //obtiene el numero de secuencia segun la letra ingresada
    //si la letra no tiene nro de secuencia entonces retorna cero y un mensaje indicando esto
     $("#protocolo-letra").change(function() {
        var letra   = $("#protocolo-letra").val();
        var anio    = $("#protocolo-anio").val();
        var nro_sec         = $("#protocolo-nro_secuencia").val();
        var protocolo_id    = $("#protocolo-id").val();
        $.ajax({
            url    : "index.php?r=protocolo/cambio-letra",
            type   : "post",
            data   : {
                        letra:  letra,
                        anio:   anio,
                        nro_secuencia:  nro_sec,
                        protocolo_id:   protocolo_id
                    },
            success: function (response) 
            {                         
                if(response.rta===true){
                    $("#dynamic-form").yiiActiveForm("updateAttribute", "protocolo-nro_secuencia","");
                    $("#protocolo-nro_secuencia").val(response.nro_secuencia);
                    if ($("#protocolo-id").hasClass("no-permitido-borrar")===true) {
                        $("#protocolo-id").removeClass("no-permitido-borrar"); 
                    }  
                }   
                if(response.rta===false){
                    $("#protocolo-nro_secuencia").val(response.nro_secuencia);
                    $("#dynamic-form").yiiActiveForm("updateMessages", {
                        "protocolo-nro_secuencia": [response.mensaje]
                    }, true);  
                     $("#protocolo-id").addClass( "no-permitido-borrar" );
                }             
            }               
        });
    }); 

});
$("#protocolo-nro_secuencia").change(function() {
    numeroSecuenciaLetraUpdate();
}); 

function numeroSecuenciaLetraUpdate(){
    var letra           = $("#protocolo-letra").val();
    var anio            = $("#protocolo-anio").val();
    var nro_sec         = $("#protocolo-nro_secuencia").val();
    var protocolo_id    = $("#protocolo-id").val();
    $.ajax({
        url    : "index.php?r=protocolo/existe-nro-secuencia-letra-update",
        type   : "post",
        data   : {
                    letra:          letra,
                    anio:           anio,
                    nro_secuencia:  nro_sec,
                    protocolo_id:   protocolo_id
                },
        success: function (response) 
        {                         
            if(response.rta===false){
                $("#dynamic-form").yiiActiveForm("updateAttribute", "protocolo-nro_secuencia","");           
                if ($("#protocolo-id").hasClass("no-permitido-borrar")===true) {
                    $("#protocolo-id").removeClass("no-permitido-borrar"); 
                }          
            }   
            if(response.rta===true){                    
                $("#dynamic-form").yiiActiveForm("updateMessages", {
                    "protocolo-nro_secuencia": [response.mensaje]
                }, true);  
                $("#protocolo-id").addClass( "no-permitido-borrar" );
            }             
        }               
    });
 }   


$("#protocolo-nro_secuencia").keydown(function(e) {
    if(!isNaN(this.value)){
        var numeroSinCeros= parseInt(this.value,10);
        var digitos = numeroSinCeros.toString().length;
        if( (digitos>=7) && (e.keyCode != 8) ){
            return false;
        }
    }
    
});

$("#protocolo-nro_secuencia").keyup(function() {
 
    function pad(input, length, padding) {
        var
        str = input + "";
        return (length <= str . length) ? str : pad(padding + str, length, padding);
    }
   if (!isNaN(this.value)){
        var
        numeroSinCeros = parseInt(this . value, 10);
        var
        digitos = numeroSinCeros . toString() . length;
        $("#protocolo-nro_secuencia") . val(pad(numeroSinCeros, 7, 0));
    }else{
        $("#protocolo-nro_secuencia").val(pad(0, 7, 0));
    }

 });


';

$this->registerJs($js);
?>


<?php if (Yii::$app->session->hasFlash('success')): ?>
  <div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i>Saved!</h4>
  <?= Yii::$app->session->getFlash('success') ?>
  </div>
  
<?php endif; ?>


<?php
    Modal::begin([
            'id' => 'modalNuevoMedico',
           // 'size'=>'modal-lg',
            'options' => ['tabindex' => false ],
        ]);
        echo "<div id='modalContent'></div>";
 Modal::end();
?>

<?php
    Modal::begin([
            'id' => 'modalNuevaProcedencia',
           // 'size'=>'modal-lg',
            'options' => ['tabindex' => false ],
        ]);
        echo "<div id='modalContentProcedencia'></div>";
 Modal::end();
?>


<?= Html::csrfMetaTags() ?>


<div class="box">
    <div class="box-body">
        <?php
            $form = ActiveForm::begin([
                    'id'  => 'dynamic-form',
                    'options' => [
                        'class' => 'form-horizontal mt-10',
                        'enableAjaxValidation' => true,
                        'data-pjax' => '',
                    ]
            ]);
            echo  $form->field($model, 'id')->hiddenInput()->label(false);
        ?>
        
        <input type="hidden" name="tanda" value="<?php // $tanda ?>" id="tanda">

        <div class="col-md-6" style="text-align: right; margin-bottom:-10px">
            <div class="col-md-4" style="text-align: right;">
                <h5><strong>Nro</strong></h5>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'anio', ['template' => "
                                                <div class=''>{input}</div>
                                                {hint}
                                                {error}",
                                            'labelOptions' => [ 'class' => 'col-md-1 ' ]
                        ])->textInput(['maxlength' => false,'readonly' =>true]) ?>
                </div>
                <div class="col-md-1">
                        <?= $form->field($model, 'letra', ['template' => "
                                                    <div class='' placeholder='Letra'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                    'labelOptions' => [ 'class' => 'col-md-2' ]
                        ])->textInput(['maxlength' => false]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'nro_secuencia',['template' => "
                                        <div>{input}</div>
                                        {hint}
                                        {error}",
                ])->textInput() ?>
            </div>
        </div>
        <div class="col-md-6" style="text-align: right;">
            <?= $form->field($model, 'numero_hospitalario',['template' => "{label}
                                             <div class='col-md-7'>{input}</div>
                                             {hint}
                                             {error}",
                                              'labelOptions' => [ 'class' => 'col-md-4 control-label' ]
            ])->textInput()->error([ 'style' => ' text-align: center;'])?>
        </div>
        <div class="col-md-6" style="text-align: right;">
                 <?=$form->field($model, 'fecha_entrada',['template' => "{label}
                            <div class='col-md-7' >
                            {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                            ])->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                ])->error([ 'style' => ' float: left; margin-left: 35%;']);?>
        </div>
        <div class="col-md-6" style="text-align: left;">
                <?php
                echo $form->field($model, 'fecha_entrega',['template' => "{label}
                <div class='col-md-7' >
                {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                ])->widget(DateControl::classname(), [
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>true,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ])->error([ 'style' => ' float: left; margin-left: 35%;']);
                ?>
        </div>      
        <div class="col-md-6" style="text-align: right;">
              <div class="row">
                    <div class="col-md-12">
                        <?php 
                            echo $form->field($model, 'Medico_id',
                            ['template' => "{label}
                                <div class='col-md-7' >
                                {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                                ]
                                )->widget(Select2::classname(), [
                                    'initValueText' => 'Ingrese Médico',
                                    'options' => [  'placeholder' => 'Buscar Médico ...',
                                    ],
                                    'pluginOptions' => [
                                  //      'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'ajax' => [
                                            'url' => Url::to(['medico/list']),
                                            'dataType' => 'json',
                                            'delay' => 250,
                                            'data' => new JsExpression('function(params) { return {term:params.term  }; }'),
                                            'processResults' => new JsExpression('function(data) {
                                                return {
                                                    results: $.map(data, function(item, index) {
                                                        return {
                                                        "id": item.id,
                                                        "text": item.nombre 
                                                        };
                                                    })
                                                    };
                                                }'),
                                            'cache' => true
                                        ],
                                    ],
                            ]);
                        ?>
                        <?php /*yii\widgets\Pjax::begin(['id' => 'new_medico']);
                           $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');
                            echo $form->field($model, 'Medico_id',
                                    ['template' => "{label}
                                        <div class='col-md-6' >
                                            {input}  </div>
                                            
                                            {hint}{error}
                                            "
                                        ,'labelOptions' => [ 'class' => 'col-md-5  control-label' ],
                                    ])->widget(Widget::className(), [
                                        'options' => [
                                            'multiple' => false,
                                            'placeholder' => 'Choose item'
                                        ],
                                            'items' => $dataMedico,
                                        'settings' => [
                                            'width' => '100%',
                                        ]
                                    ]);
                        */
                        ?>
                        <?php //yii\widgets\Pjax::end() ?>
                    </div>
            </div>
        </div>                
        <div class="col-md-6" style="text-align: right;">
            <div class="row">
                <div class="col-md-12">
                    <?php /* yii\widgets\Pjax::begin(['id' => 'new_procedencia']);
                        $dataProcedencia=ArrayHelper::map(Procedencia::find()->asArray()->all(), 'id', 'descripcion');
                    
                        echo $form->field($model, 'Procedencia_id',
                                ['template' => "{label}
                                <div class='col-md-6' >
                                    {input}  </div>
                                    
                                    {hint}{error}
                                    "
                                ,'labelOptions' => [ 'class' => 'col-md-5  control-label' ],
                                ]
                                )->widget(Widget::className(), [
                        'options' => [
                            'multiple' => false,
                            'placeholder' => 'Choose item'
                        ],
                            'items' => $dataProcedencia,
                        'settings' => [
                            'width' => '100%',
                        ]
                    ]);
                    */
                    ?>
                    <?php
                    echo $form->field($model, 'Procedencia_id',
                                ['template' => "{label}
                                                <div class='col-md-7'>{input}</div>
                                                {hint}{error}",
                                                'labelOptions' => [ 'class' => 'col-md-4 control-label' ]]
                                )->widget(Select2::classname(), [
                                        'initValueText' => 'Procedencia',
                                        'options' => [  'placeholder' => 'Procedencia ...',
                                ],
                                        'pluginOptions' => [
                                        //'allowClear' => true,
                                            'minimumInputLength' => 1,
                                            'ajax' => [
                                                'url' => Url::to(['procedencia/list']),
                                                'dataType' => 'json',
                                                'delay' => 250,
                                                'data' => new JsExpression('function(params) { return {term:params.term  }; }'),
                                                'processResults' => new JsExpression('function(data) {
                                                    return {
                                                        results: $.map(data, function(item, index) {
                                                            return {
                                                            "id": item.id,
                                                            "text": item.descripcion 
                                                            };
                                                        })
                                                        };
                                                    }'),
                                                'cache' => true
                                            ],
                                        ],
                                ]);  
                        ?>
                        <?php //yii\widgets\Pjax::end() ?>
                    </div>
            </div>
        </div>    
        <div class="col-md-6" style="text-align: right;">
            <?php
                //$dataFacturar=ArrayHelper::map(Prestadoras::find()->where(['facturable' => 'S'])->asArray()->all(), 'id', 'descripcion');
                echo $form->field($model, 'FacturarA_id',
                            ['template' => "{label}
                                <div class='col-md-7' >
                                {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                                ]
                                )->widget(Select2::classname(), [
                                    'initValueText' => 'Facturar a',
                                    'options' => [  'placeholder' => 'Facturar a ...',
                                    ],
                                    'pluginOptions' => [
                                    //    'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'ajax' => [
                                            'url' => Url::to(['prestadoras/facturar']),
                                            'dataType' => 'json',
                                            'delay' => 250,
                                            'data' => new JsExpression('function(params) { return {term:params.term  }; }'),
                                            'processResults' => new JsExpression('function(data) {
                                                return {
                                                    results: $.map(data, function(item, index) {
                                                        return {
                                                        "id": item.id,
                                                        "text": item.descripcion 
                                                        };
                                                    })
                                                    };
                                                }'),
                                            'cache' => true
                                        ],
                                    ],
                            ]);  
            ?>
        </div>
        <div class="col-md-6" style="text-align: left;">
            <?php
                $PacientePrestadoras = PacientePrestadora::find()->where(['id' => $model->Paciente_prestadora_id])->one();
                
                $Prestadoras = PacientePrestadora::find()->where(['Paciente_id' => $PacientePrestadoras->Paciente_id])->all();
                
                echo $form->field($model, 'Paciente_prestadora_id',
                            ['template' => "{label}
                                <div class='col-md-7' >
                                {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                                ]
                                )->widget(Select2::classname(), [
                                    'data' => $PacientePrestadora,
                                    'initValueText' => 'Prestadora',
                                    'options' => [  'placeholder' => 'Facturar a ...',
                                    ],
                                    
                            ]);
            ?>
        </div>        
        <div class="col-md-6" style="text-align: right;">
            <?php
                echo $form->field($model, 'observaciones', ['template' => "{label}
                                <div class='col-md-7'>{input}</div>
                                {hint}
                                {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                    ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-left: 40%;']);

                $this->registerCss('
                    .select2-container-multi {
                        margin: 0;
                        padding: 0;
                        white-space: nowrap;
                        width:96%;
                        margin-left: 15px;
                    }
                    .select2-default {
                        color: #000 !important;
                    }

                    .select2-container-multi .select2-choices .select2-search-field input {
                        padding: 5px;
                        margin: 1px 0;
                        font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;
                        font-size: 100%;
                        outline: 0;
                        border: 0;
                        -webkit-box-shadow: none;
                        box-shadow: none;
                        background: transparent !important;
                    }

                ');

            ?>
        </div> <!-- bloque izquierdo -->
        <div class="col-md-12">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsInformes[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'Estudio_id',
                    'descripcion',
                    'observaciones',
            //     'city',
            //     'state',
                //    'postal_code',
                ],
            ]); ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-file"></i> Estudios
                        <button type="button" class="pull-right add-item addItem btn btn-success btn-xs"><i class="fa fa-plus"></i> Agregar Estudio</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body container-items"><!-- widgetContainer -->
                <?php //var_dump($modelsInformes); die(); ?>
                        <?php foreach ($modelsInformes as $index => $modelInforme): ?>
                        <?php //var_dump($modelInforme); die(); ?>
                            <div class="item box box-info "><!-- widgetBody -->
                                <div class="box-header with-border bg-gray disabled">
                                    <span class="panel-title-address">Estudio: <?= ($index + 1) ?></span>
                                    <button type="button" class="pull-right remove-item btn btn-default btn-xs"><i class="fa fa-minus"></i></button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="box-body no-padding" style="margin-top:5px;">
                                    <?php  
                                        $dataEstudio=ArrayHelper::map(Estudio::find()->asArray()->all(), 'id', 'descripcion');
                                        // necessary for update action.
                                        if (!$modelInforme->isNewRecord) {
                                            echo Html::activeHiddenInput($modelInforme, "[{$index}]id");
                                        }
                                    ?>
                                    <div class="col-md-6" style="text-align: right;">

                                        <?= $form->field($modelInforme, "[{$index}]Estudio_id",['template' => "{label}
                                                    <div class='col-md-8'>{input}</div>
                                                    {hint}{error}",
                                                    'labelOptions' => [ 'class' => 'col-md-3 control-label' ]])->dropDownList( $dataEstudio, ['prompt' => ''])
                                                    ->error([ 'style' => ' float: left; margin-left: 28%;']); 
                                        ?>
                                     
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <?php
                                            $modelsInformeNomencladorArray[$index]=$modelInforme->informeNomenclador;                                                                                                                                       
                                            echo $this->render('_form-nomencladores', [
                                                        'form' => $form,
                                                        'indexEstudio' => $index,
                                                        'modelsNomenclador' =>  (empty($modelsInformeNomencladorArray[$index])) ? [new InformeNomenclador] :$modelsInformeNomencladorArray[$index]
                                                    ])
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php DynamicFormWidget::end();  ?>
        <div class="box-footer" >
            <div class="pull-right box-tools">
                <?= Html::submitButton($modelInforme->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? ' btn btn-info' : ' btn btn-primary']) ?>               
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
 <?php
      $this->registerJsFile('@web/assets/admin/js/cipat_general.js', ['depends' => [yii\web\AssetBundle::className()]]);    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js', ['depends' => [yii\web\AssetBundle::className(),  'yii\web\JqueryAsset']]);
  ?>