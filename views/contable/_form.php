<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estudio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudio-form">
    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([           
            'options' => [
                'class' => 'form-horizontal mt-10'
             ]
        ]); ?>

        <?= $form->field($model, 'descripcion', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titulo', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'columnas', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <div class="form-footer">
        <div class="col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
