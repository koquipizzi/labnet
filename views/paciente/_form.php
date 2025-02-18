<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap\Modal;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\widgets\Pjax;
    use yii\data\ActiveDataProvider;
    
    use kartik\form\ActiveField;
    use kartik\select2\Select2;
    use kartik\datecontrol\DateControl;
    
    use app\models\Localidad;
    use app\models\Sexo;
    use app\models\TipoDocumento;
    use app\models\PrestadoratempSearch;
    use app\models\Prestadoratemp;
    use app\models\PacientePrestadoraSearch;
    use app\models\PacientePrestadora;
    
    
    use xj\bootbox\BootboxAsset;
    use wbraganca\dynamicform\DynamicFormWidget;
    $js = <<<JS
       
        jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
            var linea = 0;
            jQuery(".dynamicform_wrapper .panel-title-prestadora").each(function(index) {
                jQuery(this).html("Prestadora: " + (index + 1));
                linea = index;
            });
            var select0 = jQuery(item).find("#select2-"+linea+"-prestadoras_id").html("Seleccione una Prestadora...");
            var begin = "prestadoradetalle-"+linea;
            jQuery( "*[id^="+begin+"]" ).val( "" );
        });
        
        jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
            jQuery(".dynamicform_wrapper .panel-title-prestadora").each(function(index) {
              jQuery(this).html("Prestadora: " + (index + 1))
            });
        });
        
JS;
    BootboxAsset::register($this);
    $this->registerJs($js);
    /* @var $this yii\web\View */
    /* @var $model app\models\Paciente */
    /* @var $form yii\widgets\ActiveForm */
?>


<div class="paciente-form">
    <?php
        $form = ActiveForm::begin(['id'=>'create-paciente-form'  ,
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-paciente-form',
                'enableAjaxValidation' => true,
            ]
        ]);
    ?>
    <div id="row">
        <div class="col-lg-6">
            <input type="hidden" id="PacienteId" value="<?= $model->id ?>">
            <?=
                $form->field($model, 'nombre', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}{error}", 'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);
            ?>
            <?php
                $dataTipo = ArrayHelper::map(TipoDocumento::find()->asArray()->all(), 'id', 'descripcion');
                $paciente = $model->id;
                echo $form->field($model, 'Tipo_documento_id', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}{error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->widget(Select2::classname(),
                    [
                        'data' => $dataTipo,
                        'language' => 'es'
                    ])->error([ 'style' => ' margin-left: 35%;']);;
            ?>
            <?= $form->field($model, 'nro_documento', ['template' => "{label}
            <div class='col-md-8'>{input}</div>
            {hint}
            {error}",
                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);
            ?>
            <?= $form->field($model, 'hc', ['template' => "{label}
            <div class='col-md-8'>{input}</div>
            {hint}
            {error}",
                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textInput(['maxlength' => true])
            ?>
            <?php
                $dataSexo=ArrayHelper::map(Sexo::find()->asArray()->all(), 'id', 'descripcion');
                echo $form->field($model, 'sexo', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->widget(Select2::classname(),
                    [
                        'data' => $dataSexo,
                        'language' => 'es'
                    ]);
            ?>
            <div class="">
                <?php
                    echo $form->field($model, 'fecha_nacimiento',['template' => "{label}
                <div class='input-group col-md-8' style='padding-left:15px; padding-right:15px; margin-bottom:-4px;' >
                {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                    ])->widget(DateControl::classname(), [
                       // 'type'=>DateControl::FORMAT_DATE,
                        'ajaxConversion'=>true,
                        'class' => 'col-md-8',
                        'options' => [
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ])->error([ 'style' => ' margin-left: 35%;']);;
                ?>
            </div>
            
            <?= $form->field($model, 'domicilio', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']); ?>


            <div class='row'>
                <div class="col-md-12">
                    <?php yii\widgets\Pjax::begin(['id' => 'new_localidad']);
                        $dataLocalidad = ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
                        echo $form->field($model, 'Localidad_id', ['template' => "{label}
                           <div class='col-md-8'>{input}</div>
                            {hint}
                            {error}",  
                            'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                            ])->widget(Select2::classname(),
                    [
                        'data' => $dataLocalidad,
                        'language' => 'es'
                    ]);
                    ?>
                    <?php yii\widgets\Pjax::end() ?>
                </div>
            </div>


            <div id="div_new_model" style="display:none">
                <?= Html::button('Cancel', [
                    'class' => 'btn btn-success',
                    'onclick'=>'(function ( $event ) { $("#div_new_model").hide(); })();'
                ])?>


            </div>
            
            <?= $form->field($model, 'telefono', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']); ?>
            
            <?= $form->field($model, 'email', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']); ?>
            
            <?= $form->field($model, 'notas', ['template' => "{label}
                    <div class='col-md-8'>{input}</div>
                    {hint}
                    {error}",
                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-right: 30%;'])
            ?>
            
            <?php echo Html::activeHiddenInput($prestadoraTemp, 'tanda',['id'=>'hiddenPrestadoraTemp'])?>


        </div>
        <?php  Pjax::begin(['id' => 'pjax_prestadoras']); ?>
        <div class="col-sm-6">
            <div class="customer-form">
                <div class="padding-v-md">
                    <div class="line line-dashed"></div>
                </div>
                <?php
                    DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 100, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $PacientePrestadorasmultiple[0],
                        'formId' => 'create-paciente-form',
                        'formFields' => [
                            'Paciente_id',
                            'Prestadoras_id',
                            'nro_afiliado',
                        ],
                    ]);
                ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Prestadoras
                <button type="button" class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i> Agregar Prestadora</button>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items"><!-- widgetContainer -->
                
                <?php foreach ($PacientePrestadorasmultiple as $index => $modelPrestadora): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <span class="panel-title-prestadora">Prestadora: <?= ($index + 1) ?></span>
                            <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (!$modelPrestadora->isNewRecord) {
                                    echo Html::activeHiddenInput($modelPrestadora, "[{$index}]id");
                                }
                            ?>

                            <?php
                            
                                echo $form->field($modelPrestadora, "[{$index}]nro_afiliado", ['template' => "{label}
                                    <div class='col-md-8'>{input}</div>
                                    {hint}
                                    {error}",
                                    'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                                ])->textInput(['maxlength' => true, 'class'=> $model->isNewRecord ? 'form-control crear':'form-control editar' ])
                            ?>
                            
                            <?php
                               
                                $prestadoras = app\models\Prestadoras::find()->where(['cobertura'=>1])->all();
                                $dataPrestadoras = ArrayHelper::map($prestadoras, 'id', 'descripcion');

                                echo $form->field ($modelPrestadora, "[{$index}]Prestadoras_id", ['template' => "{label}
                                        <div class='col-md-8'>{input}</div>
                                        {hint} {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]]
                                )->widget(Select2::classname(),
                                    [
                                        'data' => $dataPrestadoras,
                                        'language' => 'es'
                                    ]);
                            ?>
                          </div>
                    </div>
                <?php endforeach;  ?>
            </div>
        </div>
                <?php DynamicFormWidget::end(); ?>
    </div>
    </div>
    <br>
    <div class="" style="clear: both;"></div>
    </div>
    </div>
    <?php Pjax::end();  ?>
    <div class="box-footer col-sm-12" >
        <div class="pull-right box-tools">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=> 'enviar_paciente']) ?>
            <?= Html::a('Cancelar', ['paciente/index'], ['class'=>'btn btn-danger']) ?>
        </div>
    </div>


<?php ActiveForm::end(); ?>
<?php
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js', ['depends' => [yii\web\AssetBundle::className()]]);    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js', ['depends' => [yii\web\AssetBundle::className(),  'yii\web\JqueryAsset']]);
?>