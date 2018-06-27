<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\form\ActiveField;
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

use kartik\datecontrol\DateControl;
//Models
use app\models\Estudio;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use app\models\Medico;
use app\models\ViewPacientePrestadora;
use app\models\ViewPacientePrestadoraQuery;
use app\models\Prestadoras;
use app\models\InformeTemp;

/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
if (!$session->isActive)
                // open a session
    $session->open();

$js = '
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

    //cambia la letra a mayusculas en protocolo-letra
    $("#protocolo-letra").keyup(function(){
        this.value = this.value.toUpperCase();
    });

    //obtiene el numero de secuencia segun la letra ingresada
    //si la letra no tiene nro de secuencia entonces retorna cero y un mensaje indicando esto
    $("#protocolo-letra").change(function() {
        var letra   = $("#protocolo-letra").val();
        var anio    = $("#protocolo-anio").val();
        $.ajax({
            url    : "index.php?r=protocolo/nro-secuencia-letra",
            type   : "post",
            data   : {
                        letra:  letra,
                        anio:   anio
                    },
            success: function (response) 
            {                         
                if(response.rta===true){
                    $("#dynamic-form").yiiActiveForm("updateAttribute", "protocolo-nro_secuencia","");
                    $("#protocolo-nro_secuencia").val(response.nro_secuencia);
                }   
                if(response.rta===false){
                    $("#protocolo-nro_secuencia").val(response.nro_secuencia);
                    $("#dynamic-form").yiiActiveForm("updateMessages", {
                        "protocolo-nro_secuencia": [response.mensaje]
                    }, true);  
                }             
            }               
        });
    }); 
});
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

$this->title = 'Nuevo Protocolo: '. $paciente->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>


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


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $paciente->nombre." ( ".$prestadora->descripcion." )";  ?></h3>
    </div>

    <div class="box-body">
        <?php $form = ActiveForm::begin([
                    'id'  => 'dynamic-form',
                    'options' => [
                        'class' => 'form-horizontal mt-10',
                     //   'id' => 'form-protocolo',
                        'enableAjaxValidation' => true,
                        'data-pjax' => '',
                    ]
            ]); ?>
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
                            
                        
                        ?>
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
                                        'allowClear' => true,
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
                    </div>
                    <!--button type='button'  id='addMedico'  class=' col-md-1   btn btn-success btn-xs' 
                            value='index.php?r=medico/createpop' Style = 'width:80px;'><?php   echo Yii::t('app', 'Add');  ?>
                    </button-->
            </div>
        </div>                
        <div class="col-md-6" style="text-align: right;">
           
              <div class="row">
                    <div class="col-md-12">
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
                    </div>
            </div>
        </div>
     

        <div class="col-md-6" style="text-align: right;">

                <?php 
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
                                        'allowClear' => true,
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
                         <div class="col-md-6" style="text-align: right; ">

                            <?= $form->field($modelInforme, "[{$index}]Estudio_id",['template' => "{label}
                                             <div class='col-md-8'>{input}</div>
                                             {hint}{error}",
                                            'labelOptions' => [ 'class' => 'col-md-3 control-label' ]])->dropDownList( $dataEstudio, ['prompt' => ''])
                                            ->error([ 'style' => ' float: left; margin-left: 28%;']);
                            ?>
                             
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <?php
                                    echo $this->render('_form-nomencladores', [
                                                'form' => $form,
                                                'indexEstudio' => $index,
                                                'modelsNomenclador' => $modelsNomenclador[$index],
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
                <?= Html::resetButton(Yii::t('app', 'Cancel'), ['class' => ' btn btn-default']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
 <?php
      $this->registerJsFile('@web/assets/admin/js/cipat_general.js', ['depends' => [yii\web\AssetBundle::className()]]);    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js', ['depends' => [yii\web\AssetBundle::className(),  'yii\web\JqueryAsset']]);
  ?>
