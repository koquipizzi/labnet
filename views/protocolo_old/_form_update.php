<?php
use app\assets\admin\dashboard\DashboardAsset;
DashboardAsset::register($this);

use yii\bootstrap\Modal;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;
//yii fue sustituido por
use kartik\select2\Select2;

//Models
use app\models\Estudio;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use app\models\Medico;
use app\models\ViewPacientePrestadora;
use app\models\ViewPacientePrestadoraQuery;
use app\models\Prestadoras;

/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */
/* @var $form yii\widgets\ActiveForm */
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>


<?= Html::csrfMetaTags() ?>


<div class="protocolo-form">
    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([ 
                'id'  => 'form-protocolo',
                'options' => [
                    'class' => 'form-horizontal mt-10',
                    'id' => 'form-protocolo',
                    'enableAjaxValidation' => true,
                //    'data-pjax' => '',
                 ]
        ]); ?>
        <div class="row form-group">
                <div class="col-md-1 control-label">
                    <h4>Protocolo</h4>
                </div>            
                <div class="col-md-10 control-label">
                    <div class="col-md-4">
                                <div class="col-md-6 ">
                                 <?= $form->field($model, 'anio', ['template' => "
                                                         <div class='col-md-12'>{input}</div>
                                                         {hint}
                                                         {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-0  control-label' ]
                                   ])->textInput(['maxlength' => false]) ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'letra', ['template' => "
                                                                <div class='col-md-12 ' placeholder='Letra'>{input}</div>
                                                                {hint}
                                                                {error}",
                                                                'labelOptions' => [ 'class' => 'col-md-0  control-label' ]                                        
                                    ])->textInput(['maxlength' => false]) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model, 'nro_secuencia',['template' => "
                                                        <div class='col-md-12'>{input}</div>
                                                        {hint}
                                                        {error}",
                              ])->textInput() ?>
                                </div>
                    </div>  
                      

                    <div class="col-md-2"> 
                            <?= $form->field($model, 'nro_secuencia',['template' => "
                                                        <div class='col-md-12'>{input}</div>
                                                        {hint}
                                                        {error}",
                              ])->textInput() ?>
                    </div>
                    <div class="col-md-3"> 
                            <?= $form->field($model, 'registro', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-5  control-label' ]
                            ])->textInput(['maxlength' => true]) ?>
                    </div>                      
                    <div class="col-md-3">
                        <?= $form->field($model, 'fecha_entrada',['template' => "{label}
                                                        <div class='col-md-8'>{input}</div>
                                                        {hint}
                                                        {error}",
                                                         'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                            ])->textInput() ?>
                
                    </div>                    

                </div>
            
        </div>
        <div class="row form-group">
        <div class="col-lg-6">
        <?php
        $this->registerJs("
            $(document).on('ready', function () { 
                $('#id').addClass('form-control');  
                $('#id').attr({placeholder:'Buscar por Paciente, Obra Social o Nro.Afiliado. '});
            });");
        ?>
        <div class="form-group">
            <?php
                  $data=ArrayHelper::map(ViewPacientePrestadora::find()->asArray()->all(), 'id', 'nombreDniDescripcionNroAfiliado');
                  echo $form->field($model, 'Paciente_prestadora_id', ['template' => "{label}
                       <div class='col-md-8'>{input}</div>
                       {hint}
                       {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                          ])->widget(select2::classname(), [
                      'data' => $data,
                      'language'=>'es',
                      'options' => ['placeholder' => 'Seleccione DNI, Cobertura, Nro_Afiliado ...'],
                      'pluginOptions' => [
                          'allowClear' => false
                          ],
                      ])->error([ 'style' => ' margin-left: 40%;'])?>
         
        
         <?php   $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');
            
                echo $form->field($model, 'Medico_id', ['template' => "{label}
                       <div class='col-md-8'>{input}</div>
                       {hint}
                       {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                          ])->widget(select2::classname(), [
                      'data' => $dataMedico,
                      'language'=>'es',
                      'options' => ['placeholder' => 'Seleccione Médico ...'],
                      'pluginOptions' => [
                          'allowClear' => false
                          ],
                      ])->error([ 'style' => ' margin-left: 40%;'])?>
        <?php   $dataProcedencia=ArrayHelper::map(Procedencia::find()->asArray()->all(), 'id', 'descripcion');
                echo $form->field($model, 'Procedencia_id', ['template' => "{label}
                       <div class='col-md-8'>{input}</div>
                       {hint}
                       {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                          ])->widget(select2::classname(), [
                      'data' => $dataProcedencia,
                      'language'=>'es',
                      'options' => ['placeholder' => 'Seleccione Procedencia ...'],
                      'pluginOptions' => [
                          'allowClear' => false
                          ],
                    ])->error([ 'style' => ' margin-left: 40%;'])?>
         
        <?php 
            $dataFacturar=ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion');
            echo $form->field($model, 'FacturarA_id', ['template' => "{label}
                       <div class='col-md-8'>{input}</div>
                       {hint}
                       {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                          ])->widget(select2::classname(), [
                      'data' => $dataFacturar,
                      'language'=>'es',
                      'options' => ['placeholder' => '...'],
                      'pluginOptions' => [
                          'allowClear' => false
                          ],
                    ])->error([ 'style' => ' margin-left: 40%;'])?>
            <?= $form->field($model, 'observaciones', ['template' => "{label}
                                <div class='col-md-8'   placeholder='Ingresar Observaciones'>{input}</div>
                                {hint}
                                {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
            ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-left: 40%;'])?>

        </div>


 
        <div class="row form-group" >
            <div style="text-align: right;">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=> 'enviar_paciente']) ?>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>  
        </div>
   
        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-lg-6 panel rounded shadow">
        <div class="panel-body no-padding">
            <div class="panel-heading addPrestadora" > 
                    <div class="pull-left">
                        <h3 class="panel-title">Estudios</h3>
                    </div>
                    <div class="pull-right">
                        <i class="glyphicon glyphicon-plus" onclick="addEstudio();"></i>
                    </div>                    
                    <div class="clearfix"></div>
            </div>        
            <div id="agregarEstudio" style="display:none;" class='form-body'>
                <?php yii\widgets\Pjax::begin(['id' => 'new_estudio']) ?>   
                <form onsubmit="return false;" data-pjax ="true" id="create-informeTemp-form" action="index.php?r=informetemp/create" method="POST" class="form-horizontal">
                <?php 
                    $dataEstudio=ArrayHelper::map(Estudio::find()->asArray()->all(), 'id', 'descripcion');
                    echo $form->field($informe, 'Estudio_id',['template' => "{label}
                                    <div class='col-md-8 id='Selecmedico'>{input}</div>
                                    {hint}
                                    {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                        ])->dropDownList(
                        $dataEstudio,           
                        ['id'=>'descripcion'],
                        [ 'class' => ' chosen-container chosen-container-single chosen-container-active' ]           
                    );
                ?>
                <?= $form->field($informe, 'descripcion', ['template' => "{label}
                    <div class='col-md-8'>{input}</div>
                    {hint}
                    {error}",
                    'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                 ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($informe, 'observaciones', ['template' => "{label}
                    <div class='col-md-8'>{input}</div>
                    {hint}
                    {error}",
                    'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->textInput(['maxlength' => true]) ?>

                 <?= $form->field($nomenclador, 'servicio',[
                        'template' => "{label}
                                    <div class='col-md-8 id='Selecmedico'>{input}</div>
                                    {hint}
                                    {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]])->widget(Select2::classname(), [
                            'data'=>$nomenclador->getdropNomenclador(),'language'=>'es',
                            'toggleAllSettings' => [
                            'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> Seleccionar todos',
                            'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> Deseleccionar todos',
                            'selectOptions' => ['class' => 'text-success'],
                            'unselectOptions' => ['class' => 'text-danger'],
    ],
                            'options' => ['multiple' => true]
                ])?>
                 <?php echo $form->field($informe, 'tanda')->hiddenInput(['value'=> '0'])->label(false); ?>
                  
                    <div class="form-footer" style="text-align:right;">  
                        <?= Html::submitButton('Crear Informe', ['value' => '#', 'title' => 'Crear Informe', 'class' => ' btn btn-success btn-stroke', 'onclick' => 'send();']); ?>
                        <?php echo Html::Button('Cancelar',array('onclick'=>'$("#agregarEstudio").toggle();', 'class'=>'btn btn-danger btn-stroke')).'<span> </span>'; ?>
                    </div>   
                </div>      
            </form>
                <?php yii\widgets\Pjax::end() ?>

                <div id="estudiosInformeTemp">
                    <?php //Pjax::begin(['id' => 'estudios']) ?>
                        <?= $this->render('//protocolo/_grid', [
                             'dataProvider' => $dataProvider,
                        ]) ?>  
                    <?php //Pjax::end() ?>
                </div>
            </div>
        </div>
        </div>
          
        </div>  
      </div>  
      </div>  



