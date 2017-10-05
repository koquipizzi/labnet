<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Localidad;
use vova07\select2\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedencia-form">
    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([  'id'=>'create-procedencia-form',
            'options' => [
                'class' => 'form-horizontal mt-10',
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>

        <?= $form->field($model, 'descripcion', ['template' => "{label}
                                            <div class='col-md-7'>{input}</div>
                                            {hint}
                                            {error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-right: 30%;'])?>

    <?= $form->field($model, 'domicilio', ['template' => "{label}
                                            <div class='col-md-7'>{input}</div>
                                            {hint}
                                            {error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-right: 30%;'])?>

        <?= $form->field($model, 'mail', ['template' => "{label}
                                            <div class='col-md-7'>{input}</div>
                                            {hint}
                                            {error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput()->error([ 'style' => ' margin-right: 30%;'])?>

        <?php
            $data=ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');

            echo $form->field($model, 'Localidad_id',
                        ['template' => "{label}
                        <div class='col-md-7'>{input}</div>
                        {hint}
                        {error}",  'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
                            ]
                        )->widget(Widget::className(), [
                        'options' => [
                            'placeholder' => 'Choose item'
                        ],
                            'items' => $data,
                        'settings' => [
                            'width' => '100%',
                        ],
                ]);

                    ?>
        <?= $form->field($model, 'telefono', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true])->error([ 'style' => ' margin-right: 30%;'])?>
        <?= $form->field($model, 'informacion_adicional', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textArea(['maxlength' => true])->error([ 'style' => ' margin-right: 30%;'])?>


    <div class="box-footer">
        <div style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="reset" class="btn btn-danger">Restablecer</button>
        </div>
    </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
