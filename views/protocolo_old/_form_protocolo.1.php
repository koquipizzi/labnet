<?php
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
use vova07\select2\Widget;
use kartik\datecontrol\DateControl;
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

<div class="box-body">

        <?php $form = ActiveForm::begin([ 
                'id'  => 'form-protocolo',
                'options' => [
                    'class' => 'form-horizontal mt-10',
                    'id' => 'form-protocolo',
                    'enableAjaxValidation' => true,
                //    'data-pjax' => '',
                 ]
        ]); ?>
        <div class="row ">
                <div class="col-md-5" style="text-align: center;">
                    <h5><strong>
                    <?php 
                    echo $paciente->nombre." ( ".$prestadora->descripcion." )";
                  //  echo $form->field($model, 'Paciente_prestadora_id')->hiddenInput(['value'=> $pa])->label(false);
                    ?></strong>
                    </h5>
                    <input type="hidden" name="Protocolo[Paciente_prestadora_id]" value=<?php echo $_GET['pacprest'] ?> id="Protocolo[Paciente_prestadora_id]">
                </div> 
                <div class="col-md-1" style="text-align: right;">
                    <h5>Nro</h5>
                </div>            
                <div class="col-md-1 ">
                    <?= $form->field($model, 'anio', ['template' => "
                                            <div class=''>{input}</div>
                                            {hint}
                                            {error}",
                                           'labelOptions' => [ 'class' => 'col-md-1 ' ]
                      ])->textInput(['maxlength' => false]) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'letra', ['template' => "
                                                <div class='' placeholder='Letra'>{input}</div>
                                                {hint}
                                                {error}",
                                                'labelOptions' => [ 'class' => 'col-md-2' ]                                        
                    ])->textInput(['maxlength' => false]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'nro_secuencia',['template' => "
                                        <div>{input}</div>
                                        {hint}
                                        {error}",
              ])->textInput() ?>
                </div>
        </div>  

                   

                    <!--<div class="col-md-8" >-->
                       
                            <?php
//                            $data=ArrayHelper::map(ViewPacientePrestadora::find()->asArray()->all(), 'id', 'nombreDniDescripcionNroAfiliado');
//                            echo $form->field($model, 'Paciente_prestadora_id',
//                                    ['template' => "{label}
//                                    <div class=' col-md-10' >                
//                                    {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-2  control-label' ],                
//                                    ]
//                                    )->widget(Widget::className(), [
//                                    'options' => [
//                                        'multiple' => false,
//                                        'placeholder' => 'Choose item'
//                                    ],
//                                        'items' => $data,
//                                    'settings' => [
//                                        'width' => '100%',
//                                    ],
//                            ]);  
                           // echo $paciente->nombre." ( ".$prestadora->descripcion." )";
                            ?>
                      
                    <!--</div>-->                    

                
            
   
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
             <?=$form->field($model, 'fecha_entrada',['template' => "{label}
                            <div class='input-group col-md-8' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >                
                            {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                            ])->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
//                                'ajaxConversion'=>true,
                                'class' => 'col-md-8',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                ])->error([ 'style' => ' margin-left: 40%;'])?>
                <?= $form->field($model, 'numero_hospitalario',['template' => "{label}
                                             <div class='col-md-8'>{input}</div>
                                             {hint}
                                             {error}",
                                              'labelOptions' => [ 'class' => 'col-md-4 control-label' ]
                 ])->textInput()->error([ 'style' => ' margin-left: 40%;'])?>
            
                <?php
                echo $form->field($model, 'fecha_entrega',['template' => "{label}
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
                ])->error([ 'style' => ' margin-left: 40%;'])?>


         
        
        <?php   $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');

            echo $form->field($model, 'Medico_id',
                                    ['template' => "{label}
                                    <div class='input-group col-md-8' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >                
                                    {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                                    ]
                        )->widget(Widget::className(), [
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Choose item'
                ],
                    'items' => $dataMedico ,
                    'settings' => [
                    'width' => '100%',
                    ]
            ]);
                
            ?>
            <?php   
                $dataProcedencia=ArrayHelper::map(Procedencia::find()->asArray()->all(), 'id', 'descripcion');
                
                echo $form->field($model, 'Procedencia_id',
                        ['template' => "{label}
                        <div class='input-group col-md-8'>                
                        {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
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
            ]);?>
         
        <?php 
            $dataFacturar=ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion');
            
            echo $form->field($model, 'FacturarA_id',
                        ['template' => "{label}
                        <div class='input-group col-md-8' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >                
                        {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                        ]
                        )->widget(Widget::className(), [
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Choose item'
                ],
                    'items' => $dataFacturar,
                'settings' => [
                    'width' => '100%',
                ]
            ]);?>
            
            
            <?= $form->field($model, 'observaciones', ['template' => "{label}
                                <div class='col-md-8'   placeholder='Ingresar Observaciones'>{input}</div>
                                {hint}
                                {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
            ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-left: 40%;'])?>

        </div>

            <input type="hidden" name="tanda" value="0" id="hiddenInformeTemp">
 
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
                                ['prompt'=>'Seleccionar Estudio'],
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
		
                <div id="selector-servicio_refresh">                
                <?php 
                    
                    echo $form->field($nomenclador, 'servicio',
                        ['template' => "{label}
                        <div class='input-group col-md-8' style='padding-left:10px; padding-right:10px; margin-bottom:-4px;' >                
                        {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                        ]
                        )->widget(Widget::className(), [
                'options' => [
                    'multiple' => true,
                    'placeholder' => 'Seleccione nomencladores',
                    'class'=>'selNom'
                ],
                    'items' => $nomenclador->getdropNomenclador(),
                'settings' => [
                    'width' => '100%',
                ]
            ]);
                ?>
                 </div> 
                 <?php echo $form->field($informe, 'tanda')->hiddenInput(['value'=> '0'])->label(false); ?>
                
                    <div class="form-footer" style="text-align:right;">  
                        <?= Html::submitButton('Crear Informe', ['value' => '#', 'title' => 'Crear Informe', 'class' => ' btn btn-success btn-stroke', 'onclick' => 'send();']); ?>
                        <?php echo Html::Button('Cancelar',array('onclick'=>'$("#agregarEstudio").toggle();', 'class'=>'btn btn-danger btn-stroke')).'<span> </span>'; ?>
                    </div>   
                </div>      
            </form>
                <?php yii\widgets\Pjax::end() ?>
            
                <div id="estudiosInformeTemp">
                        <?= $this->render('//protocolo/_grid', [
                             'dataProvider' => $dataProvider,'tanda' => $tanda,'model'=>$informe,
                        ]) ?>      
                </div>
                
                
            </div>
        </div>
        </div>
          
        </div>  
      </div>   