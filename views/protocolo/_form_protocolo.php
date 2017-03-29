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
$this->title = 'Protocolo de '. $paciente->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>


<?= Html::csrfMetaTags() ?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $paciente->nombre." ( ".$prestadora->descripcion." )";  ?></h3>
    </div>
                         
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

        <!--div class="row ">
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
        </div--> 

        <div class="row ">
            <div class="col-md-6">
                <div class="col-md-4" style="text-align: right;">
                    <h5><strong>Nro</strong></h5>
                </div>            
                <div class="col-md-2">
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
                <div class="col-md-4">
                    <?= $form->field($model, 'nro_secuencia',['template' => "
                                        <div>{input}</div>
                                        {hint}
                                        {error}",
              ])->textInput() ?>
                </div>
            
                 <?= $form->field($model, 'numero_hospitalario',['template' => "{label}
                                             <div class='col-md-7'>{input}</div>
                                             {hint}
                                             {error}",
                                              'labelOptions' => [ 'class' => 'col-md-4 control-label' ]
                 ])->textInput()->error([ 'style' => ' text-align: center;'])?>

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
                ])->error([ 'style' => ' text-align: center;']); ?>
            
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
                ])->error();
                ?>

               <?php   $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');

            echo $form->field($model, 'Medico_id',
                                    ['template' => "{label}
                                    <div class='col-md-7' >                
                                    {input}</div>{hint}{error}",'labelOptions' => [ 'class' => 'col-md-4  control-label' ],                
                                    ]
                        )->widget(Widget::className(), [
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Choose item'
                ],
                    'items' => $dataMedico ,
                    'settings' => [
                        'class'=> 'form-group',
                    'width' => '100%',
                    ]
            ]);               
            ?>
            <?php   
                $dataProcedencia=ArrayHelper::map(Procedencia::find()->asArray()->all(), 'id', 'descripcion');
                
                echo $form->field($model, 'Procedencia_id',
                        ['template' => "{label}
                        <div class='col-md-7'>                
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
            ]);
            
                $dataFacturar=ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion');
            
                echo $form->field($model, 'FacturarA_id',
                        ['template' => "{label}
                        <div class='col-md-7'>                
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
                ]);

                echo $form->field($model, 'observaciones', ['template' => "{label}
                                <div class='col-md-7'>{input}</div>
                                {hint}
                                {error}",
                                'labelOptions' => [ 'class' => 'col-md-4  control-label' ],
                    ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-left: 40%;']);

                    $dataEstudio=ArrayHelper::map(Estudio::find()->asArray()->all(), 'id', 'descripcion');

                ?>
                <div class="col-md-4">
                </div>
                 <div class="col-md-7">
            <?php
                    echo $form->field($informe, 'Estudio_id')->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => true,
                                        'placeholder' => 'Seleccione Estudio/s item'
                                    ],
                                    'settings' => [
                                        'class' => 'col-md-7',
                                    ],
                                    'items' =>  $dataEstudio, 
                                   
                                ]);
            
            ?>
    
            </div>

            </div>
            <div class="col-md-6">
                <input type="hidden" name="tanda" value="0" id="hiddenInformeTemp">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Estudios</h3>    
                    </div>
                    <div class="box-body">
                            <?php 
                                $dataEstudio=ArrayHelper::map(Estudio::find()->asArray()->all(), 'id', 'descripcion');

                                echo $form->field($informe, 'Estudio_id')->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => true,
                                        'placeholder' => 'Choose item'
                                    ],
                                    'settings' => [
                                        'width' => '100%',
                                    ],
                                    'items' =>  $dataEstudio, 
                                   
                                ]);
                            ?>        
                    </div>
                        <!--div id="estudiosInformeTemp">
                            <?php 
                          /*  echo $this->render('//protocolo/_grid', [
                                'dataProvider' => $dataProvider,'tanda' => $tanda,'model'=>$informe,
                            ]) ;*/
                            ?>      
                        </div-->
                    </div>
                </div> <!--box end -->
            </div> <!--col 6 end -->
      

</div>
    <div class="box-footer" >
        <div class="pull-right box-tools">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? ' btn btn-info' : ' btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('app', 'Cancel'), ['class' => ' btn btn-default']) ?>
        </div>
    </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php 
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js',
    ['depends' => [yii\web\AssetBundle::className()]]);

    Yii::app()->clientScript->registerCss('mycss', '
     .select2-container-multi .select2-choices .select2-search-field {
        margin: 0;
        padding: 0;
        white-space: nowrap;
    }

    .select2-container-multi .select2-choices .select2-search-field input {
        border: 0;
        background: transparent !important;
    }
');
?>