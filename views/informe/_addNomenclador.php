<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Prestadoras;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclador */
/* @var $form yii\widgets\ActiveForm */

use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);

?>

<div class="nomenclador-form">
    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([           
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-nomenclador-form',
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>
        
            <?= $form->field($model, 'id_informe',['template' => "{label}
                <div class='col-md-7'>{input}</div>
                {hint}
                {error}",
                'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
             ])->textInput()->error([ 'style' => ' margin-right: 30%;'])?>

        <?= $form->field($model, 'id_nomenclador', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
             'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cantidad', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
             'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true]) ?>
         

     <?php
//            $data=ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion');
//            echo $form->field($model, 'Prestadoras_id', ['template' => "{label}
//                    <div class='col-md-7'>{input}</div>
//                    {hint}
//                    {error}",  'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
//                ])->widget(select2::classname(), [
//                    'data' => $data,
//                    'language'=>'es',
//                    'options' => ['placeholder' => 'Seleccione una prestadora ...'],
//                    'pluginOptions' => [
//                        'allowClear' => true
//                        ],
//                    ])->error([ 'style' => ' margin-right: 30%;'])
                    
                    ?>

    <div class="form-footer">
        <div class="col-sm-offset-3">
            <div style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
             <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
