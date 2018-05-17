<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Localidad;
use vova07\select2\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */
/* @var $form ActiveForm */
$this->title = Yii::t('app', 'Nueva Cobertura/OS');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Coberturas/OS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
    <div class="box-header">
       
    </div>
    
    <?php $form = ActiveForm::begin([
        'id'=>'create-prestadora-form-pop',
        'options' => [
            'class' => 'form-horizontal mt-10',
            'id'=>'create-prestadora-form-pop',
            'enableAjaxValidation' => true,
            'data-pjax' => '',
        ]
    ]); ?>
    
    <?= $form->field($model, 'descripcion', [
                                                'template' => "{label} <div class='col-md-7'>{input}</div>{hint} {error}",
                                                'labelOptions' => [ 'class' => 'col-md-3  control-label']
                                            ])->textInput(['maxlength' => true])
    ?>
    
    <?php
        $data=ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre');
        
        echo $form->field($model, 'Localidad_id',   [
                                                        'template' => "{label} <div class='col-md-7'>{input}</div> {hint} {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
                                                    ])
        ->widget(Widget::className(), [
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
    
    <?= $form->field($model, 'facturable',  [
                                                'template' => "{label} <div class='col-md-7'>{input}</div> {hint} {error}",
                                                'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
                                            ])->widget(Widget::className(), [
                                                                            'options' => [
                                                                                'multiple' => false,
                                                                                'placeholder' => 'Choose item'
                                                                            ],
                                                                            'items' => ['1' => 'Si', '0' => 'No'],
                                                                            'settings' => [
                                                                                'width' => '100%',
                                                                            ],
                                                                        ]);
    ?>
    
    <?= $form->field($model, 'notas',   [
                                            'template' => "{label} <div class='col-md-7'>{input}</div> {hint} {error}",
                                            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
                                        ])->textArea(['maxlength' => true])
    ?>

    <div class="box-footer" >
        <div class="pull-right box-tools">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> -->
            <button type="reset" class="btn btn-danger" ><?php echo Yii::t('app', 'Reset') ?></button>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>

