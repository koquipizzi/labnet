<?php
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
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
$this->params['breadcrumbs'][] = Yii::t('app', 'View');


//Html::csrfMetaTags() 
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $paciente->nombre." ( ".$prestadora->descripcion." )";  ?></h3>
    </div>
    <div class="box-body">
        <div class="row ">
            <div class="col-md-6">
            <?php  $this->render('//informe-nomenclador/_form', [
                    'model' => $infnomenclador,
                ]) ; ?>
                <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' =>
                                            [
                                                [
                                                    'label'=>'Código',
                                                    'value'=>$model->getCodigo(),
                                                ],
                                                [
                                                    'label'=>'Fecha de Entrada',
                                                    'value'=>$model->getFechaEntrada(),
                                                ],

                                                [
                                                    'label'=>'Fecha de Entrega',
                                                    'value'=>$model->getFechaEntrega(),
                                                ],
                                                [
                                                    'label'=>'Médico',
                                                    'value'=>$model->medico->nombre
                                                ],

                                                [
                                                    'label'=>'Procedencia',
                                                    'value'=>$model->procedencia->descripcion
                                                ],
                                                'observaciones',
                                            ],
                                    ]) ?>
            </div>
            <div class="col-md-6">
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
                
        /*            echo $form->field($n, 'servicio',
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
                                'items' => $data_,
                            'settings' => [
                                'width' => '100%',
                            ],

            ]);*/
                ?>
                 </div> 
        
                
                    <div class="form-footer" style="text-align:right;">  
                        <?= Html::submitButton('Crear Informe', ['value' => '#', 'title' => 'Crear Informe', 'class' => ' btn btn-success btn-stroke', 'onclick' => 'send();']); ?>
                        <?php echo Html::Button('Cancelar',array('onclick'=>'$("#agregarEstudio").toggle();', 'class'=>'btn btn-danger btn-stroke')).'<span> </span>'; ?>
                    </div>   
                </div>      
            </form>
                <?php yii\widgets\Pjax::end() ?>
            
                <div id="estudiosInformeTemp">
                        <?php 
                      //  echo $this->render('//protocolo/_grid', [
                      //       'dataProvider' => $dataProvider,'tanda' => $tanda,'model'=>$informe,
                     //   ]) 
                        ?>  
              
                </div>
            </div>
                <div class="box-header with-border">
                    <h3 class="box-title">Estudios</h3>
                </div>
                <div class="box-body">
                <?php 
                   echo  $this->render('//protocolo/_nomencladores', [
                        'modeloInformeNomenclador' => $infnomenclador, 'dataProvider' => $dataProviderIN
                    ]) ;
              //      echo $this->render('//protocolo/_grid_inf_protocolo', [
              //          'dataProvider' => $dataProvider, 'model'=>$informe,'nomenclador'=>$nomenclador,
              //      ]); 
              ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php 
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js',
    ['depends' => [yii\web\AssetBundle::className()]]);

?>