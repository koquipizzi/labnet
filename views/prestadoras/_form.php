<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Localidad;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */
/* @var $form ActiveForm */
$this->title = Yii::t('app', 'Nueva Cobertura/OS');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Coberturas/OS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
              <div class="pull-right">
                            <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['prestadoras/index'], ['class'=>'btn btn-primary']) ?>
              </div>
            </div>
            <?php $form = ActiveForm::begin([  'id'=>'create-prestadora-form',
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id'=>'create-prestadora-form',
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>

    <?= $form->field($model, 'descripcion', ['template' => "{label}
                                            <div class='col-md-7'>{input}</div>
                                            {hint}
                                            {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true])
    ?>


    <?= $form->field($model, 'domicilio', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>

    <?php
    $data=ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');

    echo $form->field($model, 'Localidad_id', ['template' => "{label}
<div class='col-md-7'>{input}</div>
{hint}
{error}",  'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->widget(select2::classname(), [
        'data' => $data,
        'language'=>'es',
        'options' => ['placeholder' => 'Seleccione una Localidad ...'],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]);
    ?>


        <?= $form->field($model, 'facturable',['template' => "{label}
                                <div class='col-md-7'>{input}</div>
                                {hint}
                                {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->dropDownList(['S' => 'Si', 'N' => 'No'],['prompt'=>'Seleccionar Opción']);
?>


    <?= $form->field($model, 'telefono', ['template' => "{label}
                                <div class='col-md-7'>{input}</div>
                                {hint}
                                {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email', ['template' => "{label}
                            <div class='col-md-7'>{input}</div>
                            {hint}
                            {error}",

        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'notas', ['template' => "{label}
                            <div class='col-md-7'>{input}</div>
                            {hint}
                            {error}",
        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textArea(['maxlength' => true]) ?>


    <div class="box-footer" >
        <div class="pull-right box-tools">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> -->
            <?= Html::a('Cancelar', ['prestadoras/index'], ['class'=>'btn btn-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
