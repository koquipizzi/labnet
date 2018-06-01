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
use vova07\select2\Widget;
use kartik\datecontrol\DateControl;
//Models
use app\models\Estudio;
use app\models\TipoDocumento;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use app\models\Medico;
use app\models\Paciente;
use app\models\Sexo;
use app\models\Localidad;
use app\models\Telefono;
use app\models\ViewPacientePrestadora;
use app\models\ViewPacientePrestadoraQuery;
use app\models\Prestadoras;
use app\models\InformeTemp;
use kartik\date\DatePicker;

$this->title = 'Nuevo Protocolo ';

$this->registerJs('var ajaxurl = "' .Url::to(['paciente/datos']). '";', \yii\web\View::POS_HEAD);
                                           
$js = <<<JS



JS;

$css = <<<CSS
    .loader {
            border: 16px solid #32b3ff; /* Light grey */
            border-top: 16px solid #000000; /* Blue */
            border-radius: 50%;
            height: 60px;
            margin: 100px auto 0;
            width: 60px;
            text-align: center;
            animation: spin 2s linear infinite;
        }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

CSS;

$this->registerCss($css);

?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Paciente</h3>
        <div class="box-tools pull-right">
            <a href="<?= Url::toRoute(['paciente/create'])?>" class="btn btn-sm btn-success btn-flat pull-right">Nuevo Paciente</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class='col-md-6'>
        <?php          
                echo Select2::widget([
                        'name' => 'kv-repo-template',
                        'value' => '14719648',
                        'initValueText' => 'Ingrese texto de búsqueda',
                        'options' => [  'placeholder' => 'Buscar Paciente ...',
                                        'onchange' => 'jQuery("#clienteID").val(this.value);
                                                            id = this.value;
                                                            aux = ajaxurl + "&id=" + id;
                                                            jQuery(".lalala").html("Cargando datos del paciente...");
                                                            let div = document.createElement(\'div\');
                                                            div.className = "loader";
                                                            jQuery(".lalala").append(div);
                                                            $.get( aux , function( data ) {
                                                                var fecha = data.rta.fecha_nacimiento;
                                                                var d =  fecha.split("-");
                                                                var year = d[0];
                                                                var month = d[1];
                                                                var day = d[2];
                                                                var d = new Date(year,month-1,day);
                                                                console.log(d);
                                                                jQuery("#paciente-nombre").val(data.rta.nombre);
                                                                jQuery("#paciente-tipo_documento_id").val(data.rta.Tipo_documento_id).trigger("change");
                                                                jQuery("#paciente-nro_documento").val(data.rta.nro_documento);
                                                                jQuery("#paciente-hc").val(data.rta.hc);
                                                                jQuery("#paciente-id").val(data.rta.id);
                                                                jQuery("#paciente-sexo").val(data.rta.sexo).trigger("change");
                                                                jQuery("#paciente-fecha_nacimiento-disp").val(day+"/"+month+"/"+year);
                                                                jQuery("#paciente-fecha_nacimiento").val(year+"-"+month+"-"+day);
                                                                //Vuelvo a cargar el componente con su configuracion
                                                                var $hasDateControl = jQuery("[data-krajee-kvdatepicker]");
                                                                if ($hasDateControl.length > 0) {
                                                                    $hasDateControl.each(function() {
                                                                           var id = $(this).attr("id");
                                                                           var dcElementOptions = eval($(this).attr("data-krajee-kvdatepicker"));
                                                                           if (id.indexOf(dcElementOptions.idSave) < 0) {
                                                                               // initialize the NEW DateControl element
                                                                               var cdNewOptions = $.extend(true, {}, dcElementOptions);
                                                                               $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
                                                                               cdNewOptions.idSave = $(this).parent().next().attr("id");
                                                                               $(this).removeAttr("value name data-krajee-datecontrol");
                                                                               $(this).datecontrol(cdNewOptions);
                                                                           }
                                                                    });
                                                                }
                                                                jQuery("#paciente-domicilio").val(data.rta.domicilio);
                                                                jQuery("#paciente-localidad_id").val(data.rta.Localidad_id).trigger("change");
                                                                jQuery("#paciente-telefono").val(data.rta.telefono);
                                                                jQuery("#paciente-email").val(data.rta.email);
                                                                jQuery("#paciente-notas").val(data.rta.notas);
                                                                jQuery(".lalala").html(data.rtaPrest);
                                                            });
                                                        '
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'ajax' => [
                                'url' => Url::to(['paciente/list']),
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return {term:params.term  }; }'),
                                'processResults' => new JsExpression('function(data) {
                                    return {
                                        results: $.map(data, function(item, index) {
                                            return {
                                            "id": item.id,
                                            "text": item.nombre + " ( " + item.tipo_documento + " " + item.nro_documento + " )"
                                            };
                                        })
                                        };
                                    }'),
                            
                                'cache' => true
                            ],
                        ],
                ]);
                           
        ?>

        <?php
                

                $formpaciente = ActiveForm::begin(['action' => 'index.php?r=paciente/actualizar',
                    'options' => [
                        'class' => 'form-horizontal mt-10',
                        'id' => 'update-paciente-form',
                        'enableAjaxValidation' => true,
                    ]
                ]); ?>

                               
                                <?php

                                    echo $formpaciente->field($paciente, 'id')->hiddenInput(['value'=> ''])->label(false);

                                
                                    echo $formpaciente->field($paciente, 'nombre', ['template' => "{label}
                                        <div class='col-md-8'>{input}</div>
                                        {hint}
                                        {error}",
                                        'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                    ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);

                                
                                    $dataTipo = ArrayHelper::map(TipoDocumento::find()->asArray()->all(), 'id', 'descripcion');
                                   
                                    echo $formpaciente->field($paciente, 'Tipo_documento_id', ['template' => "{label}
                                    <div class='col-md-8'>{input}</div>
                                    {hint}
                                    {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                    ])->widget(Select2::classname(), [
                                        'data' => $dataTipo,
                                    //  'language' => 'de',
                                        'options' => ['placeholder' => 'Seleccionar tipo de documento...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    
                                    echo $formpaciente->field($paciente, 'nro_documento', ['template' => "{label}
                                        <div class='col-md-8'>{input}</div>
                                        {hint}
                                        {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);
                                        
                                        echo $formpaciente->field($paciente, 'hc', ['template' => "{label}
                                        <div class='col-md-8'>{input}</div>
                                        {hint}
                                        {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                            ])->textInput(['maxlength' => true]);
                                    
                                    $dataSexo=ArrayHelper::map(Sexo::find()->asArray()->all(), 'id', 'descripcion');

                                    echo $formpaciente->field($paciente, 'sexo', ['template' => "{label}
                                        <div class='col-md-8'>{input}</div>
                                        {hint}
                                        {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                        ])->widget(Select2::classname(), [
                                            'data' => $dataSexo,
                                        //  'language' => 'de',
                                            'options' => ['placeholder' => 'Seleccionar Género...'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
    
                         
                                    echo $formpaciente->field($paciente, 'fecha_nacimiento',['template' => "{label}
                                        <div class='input-group col-md-8' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >
                                        {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                                    ])->widget(DateControl::classname(), [
                                        'type'=>DateControl::FORMAT_DATE,
                                        'ajaxConversion'=>true,
                                        'class' => 'col-md-8',
                                        'options' => [
                                            'pluginOptions' => [
                                                'autoclose' => true
                                            ]
                                        ]
                                    ])->error([ 'style' => ' margin-left: 35%;']);
                                
                                    echo $formpaciente->field($paciente, 'domicilio', ['template' => "{label}
                                        <div class='col-md-8'>{input}</div>
                                        {hint}
                                        {error}",
                                                    'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                    ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);

                                    yii\widgets\Pjax::begin(['id' => 'new_localidad']);
                                    
                                    $dataLocalidad = ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
                                    
                                    echo $formpaciente->field($paciente, 'Localidad_id', ['template' => "{label}
                                        <div class='col-md-8'>{input}</div>
                                        {hint}
                                        {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                        ])->widget(Select2::classname(), [
                                            'data' => $dataLocalidad,
                                        //  'language' => 'de',
                                            'options' => ['placeholder' => 'Seleccionar Localidad...'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);


                                        ?>
                                        <?php yii\widgets\Pjax::end() ?>

                                            <!--button type='button' id='addLocalidad' class=' btn btn-success btn-xs'
                                                    value='index.php?r=localidad/createpop'><?php   echo Yii::t('app', 'Add');  ?> 
                                            </button-->

                                        <?php
                                        
                                        echo $formpaciente->field($paciente, 'telefono', ['template' => "{label}
                                                <div class='col-md-8'>{input}</div>
                                                {hint}
                                                {error}",
                                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);

                                    echo $formpaciente->field($paciente, 'email', ['template' => "{label}
                                            <div class='col-md-8'>{input}</div>
                                            {hint}
                                            {error}",
                                            'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                        ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);

                                    echo $formpaciente->field($paciente, 'notas', ['template' => "{label}
                                            <div class='col-md-8'>{input}</div>
                                            {hint}
                                            {error}",
                                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                            ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-right: 30%;']);


                                ?>
                </div>
            
                <div class='col-md-6 lalala'>
                
                </div>            
                </div> <!-- cierra row -->
                <div class="row" >
                            <div class='col-md-12'>
                            <div class="box-footer" >
                                    <div class="pull-right box-tools">
                                        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => $paciente->isNewRecord ? 'enviarButon btn btn-info' : ' btn btn-primary']) ?>
                                        <?= Html::resetButton(Yii::t('app', 'Cancel'), ['class' => ' btn btn-default']) ?>
                                    </div>
                                </div>
                            <?php
                            ActiveForm::end();
                            ?>
                            </div>
                </div>
    </div>
</div>

<?php
      $this->registerJsFile('@web/assets/admin/js/cipat_nuevo_prot.js', ['depends' => [yii\web\AssetBundle::className()]]);    
?>
