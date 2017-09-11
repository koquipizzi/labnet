<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use app\models\Localidad;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use vova07\select2\Widget;
use kartik\widgets\Select2;

$this->registerJsFile('@web/assets/admin/js/cipat_add_forms.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>

<div class="box-body">

        <?php $form = ActiveForm::begin(['id'=>'create-medico-form'  ,
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-medico-form',
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>

        <?= $form->field($model, 'nombre', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true]);?>


        <?= $form->field($model, 'email', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
         ])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'telefono', ['template' => "{label}
                <div class='col-md-7'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'domicilio', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textArea(['maxlength' => true]);?>
       
        <?php
            $data=ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
            echo $form->field($model, 'localidad_id', ['template' => "{label}
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
        <?php
            $data= ArrayHelper::map(\app\models\Especialidad::find()->asArray()->all(), 'id', 'nombre');
            echo $form->field($model, 'especialidad_id', ['template' => "{label}
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
        
    </div>
    <div class="box-footer" >
        <div class="pull-right box-tools">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? ' btn btn-info' : ' btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('app', 'Cancel'), ['class' => ' btn btn-default']) ?>
        </div>
    </div>
        <?php ActiveForm::end(); ?>

    </div>


