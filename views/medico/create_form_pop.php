<?php
 
 use yii\helpers\Html;
 use yii\widgets\ActiveForm;
 /* @var $this yii\web\View */
 /* @var $model app\models\Localidad */
 /* @var $form yii\widgets\ActiveForm */
 use yii\helpers\Url;
 use yii\helpers\ArrayHelper;
 use vova07\select2\Widget;
 use yii\bootstrap\Modal;
 use kartik\rating\StarRating;
use app\models\Localidad;

 ?>
<?php 

?>
     <div class="panel-body no-padding">
         <?php $form = ActiveForm::begin([
             'options' => [
                 'class' => 'form-horizontal mt-10',
                 'id' => 'create-medico-form-pop',
             //    'enableAjaxValidation' => true,
                 'data-pjax' => 'true',
                 'action' => 'medico/createpop',
              ]
         ]); ?>
 
     <?= $form->field($model, 'nombre', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true]);?>
 
    
    <?= $form->field($model, 'domicilio', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true]);?>               
    <?php
            $data=ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
            echo $form->field($model, 'Localidad_id', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",  'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
            ])->widget(Widget::className(),
                    [
                        'options' => [
                            'multiple' => false,
                            'placeholder' => 'Choose item'
                        ],
                            'items' => $data,
                        'settings' => [
                            'width' => '100%',
                        ],
                    ]);
        ?>
         <?= $form->field($model, 'notas', ['template' => "{label}
                <div class='col-md-7'>{input}</div>
                {hint}
                {error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
               ])->textArea(['maxlength' => true]);?>   

 
     <div class="form-footer">
         <div style="text-align: right;">           
             <button type="reset" class="btn btn-danger">Restablecer</button>         
             <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
     </div>
 
         <?php ActiveForm::end(); ?>
     </div>