<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarifas-form">
    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([           
            'options' => [
                'class' => 'form-horizontal mt-10'
             ]
        ]); ?>

        <?= $form->field($model, 'valor', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coseguro', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Procedencia_id',['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput() ?>

    <?= $form->field($model, 'Prestadoras_id',['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput() ?>

    <?= $form->field($model, 'Nomenclador_id',['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
                    'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput() ?>

    <div class="form-footer">
        <div class="col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
