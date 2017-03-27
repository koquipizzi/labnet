<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use yii\helpers\Url;

use yii\web\JsExpression;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\InformeTemp */
/* @var $form yii\widgets\ActiveForm */
use app\models\Estudio;    
use app\assets\admin\dashboard\DashboardAsset;
DashboardAsset::register($this);

       ?>

<div class="informe-form">
    <div class="panel-body no-padding">
  <?php $form = ActiveForm::begin([            
           'options' => [
               'class' => 'form-horizontal mt-10',
               'id' => 'create-informeTemp-form',
               'enableAjaxValidation' => true,
               'data-pjax' => '',
            ]
       ]); ?>
        <?php 
            $dataEstudio=ArrayHelper::map(Estudio::find()->asArray()->all(), 'id', 'descripcion');
            echo $form->field($informe, 'Estudio_id',['template' => "{label}
                            <div class='col-md-7 id='Selecmedico'>{input}</div>
                            {hint}
                            {error}",
                        'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                ])->dropDownList(
                $dataEstudio,           
                ['id'=>'descripcion'],
                [ 'class' => ' chosen-container chosen-container-single chosen-container-active' ]           
            );
        ?>  
        <?= $form->field($informe, 'descripcion', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
         ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($informe, 'observaciones', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
        ])->textInput(['maxlength' => true]) ?>
       
            <?= Html::activeHiddenInput($informe, 'tanda')?>  
            <div class="form-footer">
                <div class="col-sm-offset-3">
                    <?= Html::submitButton('Crear Informe', ['value' => Url::to(['informetemp/Create']), 'title' => 'Crear Informe', 'class' => ' btn btn-success']); ?>
                </div>
            </div>     
    </div>
 <?php ActiveForm::end(); ?>   
    </div>
</div>

<style>
    .summary{
        float:left;
    }
    
    /* Agregado de regla para que se visualice el Autocomplete en el Modal*/
    
    .ui-autocomplete {
        z-index: 1060; 
    }

</style>

