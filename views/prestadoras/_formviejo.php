<?php
//use app\assets\admin\dashboard\DashboardAsset;
//DashboardAsset::register($this);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use app\models\TipoPrestadora;
use app\models\Localidad;
use kartik\typeahead\TypeaheadBasic;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */
/* @var $form yii\widgets\ActiveForm */
?>
    

<?php //yii\widgets\Pjax::begin(['id' => 'nueva_prestadora']) ?>
<div class="prestadoras-form">
    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([           
            'options' => [
                'class' => 'form-horizontal mt-10',
               /// 'data-pjax' => true,
                 'id' => 'create-prestadora-form',
              //   'enableClientValidation' => true,
             ]
        ]); ?>
  
        <?= $form->field($model, 'descripcion', ['template' => "{label}
                    <div class='col-md-8'>{input}</div>
                    {hint}
                    {error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>
        
        <div class="row">
       
               <div class="col-md-6"> 

    <?= $form->field($model, 'telefono', ['template' => "{label}
                                <div class='col-md-6'>{input}</div>
                                {hint}
                                {error}",
                                'labelOptions' => [ 'class' => 'col-md-6  control-label' ]
                        ])->textInput(['maxlength' => true]) ?>
               </div>

             <div class="col-md-6">  
                 
    <?= $form->field($model, 'email', ['template' => "{label}
                            <div class='col-md-8'>{input}</div>
                            {hint}
                            {error}",
                            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
                    ])->textInput(['maxlength' => true]) ?>
                 
                     
             </div>
        </div>      
       
            
    <div class="row">
       
        <div class="col-md-6">
            <?= $form->field($model, 'domicilio', ['template' => "{label}
                                    <div class='col-md-6'>{input}</div>
                                    {hint}
                                    {error}",
                                    'labelOptions' => [ 'class' => 'col-md-6  control-label' ]
                                    ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <label class="col-md-2  control-label" for="descripcion">Localidad</label>
            <div class="col-md-10">
                <?php
                    $data=ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
                    echo TypeaheadBasic::widget([
                        'model' => $model, 
                        'attribute' => 'Localidad_id',
                        'data' => $data,
                        'options' => ['placeholder' => 'Ingrese localidad ...'],
                        'pluginOptions' => ['highlight'=>true],
                    ]);
                ?>
            </div> 
             <?php //echo Html::activeHiddenInput($model, 'Localidad_id'); ?>  
        </div>
    </div>        
        <div id="row"> 
             <div class="col-md-6">
            <?= $form->field($model, 'Tipo_prestadora_id', ['template' => "{label}
                                    <div class='col-md-6'>{input}</div>
                                    {hint}
                                    {error}",
                                    'labelOptions' => [ 'class' => 'col-md-6  control-label' ]
                                    ])->textInput(['maxlength' => true]) ?>
        </div>
            <div class="col-md-6">
                   <?php 
                     //se usa ArrayHelper definido antes
                     $dataTipo=ArrayHelper::map(TipoPrestadora::find()->asArray()->all(), 'id', 'descripcion');
                     echo $form->field($model, 'Tipo_prestadora_id',['template' => "{label}
                                     <div class='col-md-6'>{input}</div>
                                     {hint}
                                     {error}",
                               
                         ])->dropDownList(
                         $dataTipo,           
                         ['id'=>'descripcion'],
                         [ 'class' => ' chosen-container chosen-container-single chosen-container-active' ]           
                     ); 
                     ?>                           
            </div>
            <div class="col-md-6">
                <?php echo $form->field($model, 'facturable')->checkBox(['label' => ' Facturable', 
                'uncheck' => '0', 'checked' => '1']) ?>  
            </div>              
        </div>

        </div>
    <div class="form-footer">
        <div class="col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php //yii\widgets\Pjax::end() ?>