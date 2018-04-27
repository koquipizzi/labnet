<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;


 
use yii\helpers\ArrayHelper;
use app\models\Localidad;
use app\models\Sexo;
use app\models\TipoDocumento;
use kartik\form\ActiveField;
use yii\widgets\Pjax;
use app\models\PrestadoratempSearch;
use app\models\Prestadoratemp;
use app\models\PacientePrestadoraSearch;
use app\models\PacientePrestadora;
use yii\data\ActiveDataProvider;
use vova07\select2\Widget;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_paciente.js',
    ['depends' => [yii\web\AssetBundle::className()]]);
?>
<?= Html::csrfMetaTags() ?>


<div class="paciente-form">  
   <?php $form = ActiveForm::begin(['id' => 'dynamic-form',

    // $form = ActiveForm::begin(['id'=>'create-paciente-form'  ,   
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-paciente-form',
                'enableAjaxValidation' => true,
            //    'data-pjax' => '',
             ]
        ]); ?>
    <div id="row">
        <div class="col-lg-6">
            <input type="hidden" id="PacienteId" value="<?= $model->id ?>">            
            <?= $form->field($model, 'nombre', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']);?>
            <?php
                $dataTipo = ArrayHelper::map(TipoDocumento::find()->asArray()->all(), 'id', 'descripcion');   
                $paciente = $model->id;
                echo $form->field($model, 'Tipo_documento_id', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => false,
                                        'placeholder' => 'Choose item'
                                    ],
                                        'items' => $dataTipo,
                                    'settings' => [
                                        'width' => '100%','text-align' => 'left'
                                    ],
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
                ])->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => false,
                                        'placeholder' => 'Choose item'
                                    ],
                                        'items' => $dataSexo,
                                    'settings' => [
                                        'width' => '100%',
                                    ],
                            ]); 
            ?>
            <div class="">
                <?php
                echo $form->field($model, 'fecha_nacimiento',['template' => "{label}
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
                ])->error([ 'style' => ' margin-left: 35%;']);;
                ?>
            </div>

            <?= $form->field($model, 'domicilio', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",
                            'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
            ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-left: 35%;']); ?>
            
            <?php 
                $dataLocalidad = ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre'); 
                echo $form->field($model, 'Localidad_id', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => false,
                                        'placeholder' => 'Choose item'
                                    ],
                                        'items' => $dataLocalidad,
                                    'settings' => [
                                        'width' => '100%',
                                    ],
                            ])->error([ 'style' => ' margin-left: 35%;']);;                           
            ?>
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
            <div style="text-align: right;">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=> 'enviar_paciente']) ?>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>    
        </div>
    </div>
        
        
         
        <?php ActiveForm::end(); ?>        
        <div class="col-lg-6 panel rounded shadow">
            <div class="panel-body no-padding">
                <div class="panel-heading addPrestadora" > 
                    <div class="pull-left">
                        <h3 class="panel-title">Prestadoras</h3>
                    </div>
                    <div class="pull-right">
                        <i class="glyphicon glyphicon-plus" onclick="addPrestadora();"></i>
                    </div>                    
                    <div class="clearfix"></div>
                </div>
                <div id="agregarPrestadora" style="display:none;" class="form-body">
                <?php yii\widgets\Pjax::begin(['id' => 'new_prestadora']) ?>   
                <?php $form2 = ActiveForm::begin([  'id'=>'create-prestadoraTemp-form', 
                                                    'action' => '#',
                    'options' => [
                        'class' => 'form-horizontal mt-10',
                        'id' => 'create-prestadoraTemp-form',
                        'enableAjaxValidation' => true,                   
                     ]
            ]); ?>
                <!--div onsubmit="return false;" id="create-prestadoraTemp-form" class="form-horizontal"-->
                <?php 
                $dataPrestadoras=ArrayHelper::map(app\models\Prestadoras::find()->where(['cobertura'=>1])->all(), 'id', 'descripcion');
                echo $form2->field($prestadoraTemp, 'Prestadora_id', ['template' => "{label}
                <div class='col-md-8'>{input}</div>
                {hint}
                {error}",  'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                ])->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => false,
                                        'placeholder' => 'Choose item'
                                    ],
                                        'items' => $dataPrestadoras,
                                    'settings' => [
                                        'width' => '100%',
                                    ],
                            ]);   
                ?>  
                <?php echo $form2->field($prestadoraTemp, 'nro_afiliado', ['template' => "{label}
                    <div class='col-md-8'>{input}</div>
                    {hint}
                    {error}",
                    'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                 ])->textInput(['maxlength' => true, 'class'=> $model->isNewRecord ? 'form-control crear':'form-control editar' ]) ?>           

                <div class="form-footer" style="text-align:right;">
                <?php                      
                    if ($model->isNewRecord)
                        echo Html::Button('Agregar Prestadora',array('onclick'=>'send_prestadora();', 'class'=>'btn btn-success btn-stroke'));  
                    else                         
                        echo Html::Button('Agregar Prestadora',array('onclick'=>'send_prestadora_edit();', 'class'=>'btn btn-success btn-stroke'));  
                    
                    echo Html::activeHiddenInput($prestadoraTemp, 'tanda',['id'=>'hiddenPrestadoraTemp']);
                    echo Html::Button('Cancelar',array('onclick'=>'$("#agregarPrestadora").toggle();', 'class'=>'btn btn-danger btn-stroke')).'<span> </span>';?>  
                </div>
                <?php ActiveForm::end(); ?>
                </div>
             </div>
            <?php yii\widgets\Pjax::end() ?>

            <div id="prestadorasTemp">
                <?php Pjax::begin(['id' => 'prestadoras']);
          /*          if ($model->isNewRecord ){
                        $searchModel = new PrestadoratempSearch();
                        $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams,$tanda);
                        $prestadoraTemp = new Prestadoratemp();                        
                    }
                    else { 
//                        $searchModel = new PacientePrestadoraSearch();
//                        $dataPrestadoras = $searchModel->search(Yii::$app->request->queryParams,$model->id);
//                        $prestadoraTemp = new app\models\PacientePrestadora(); 
       //         $query = PacientePrestadora::find()->where(['Paciente_id' => $paciente]);
      //          $dataPrestadoras = new ActiveDataProvider([
                    'query' => $query,                       
                ]);
                $prestadoraTemp = new PacientePrestadora();                          
                    }
          */          
                ?>
                <?= $this->render('//paciente/_grid', [
                        'dataProvider' => $dataPrestadoras,
                        'model'=> $prestadoraTemp
                ]) ?>  
                <?php Pjax::end(); ?>                        
            </div>
            </div>
        </div>

        <br>
    <div class="" style="clear: both;">
        <!--div style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=> 'enviar_paciente']) ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div-->         
    </div>
    </div>

</div>

