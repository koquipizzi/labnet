<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\helpers\Helper;
use yii\widgets\Pjax;

?>
  <?php
  
  $js = '
    
    $("#idFile").on("fileuploaded", function(event) {
        $.pjax.reload({container:"#galeriaL"});
    });
    
    $("#idFile2").on("fileuploaded", function(event) {
        $.pjax.reload({container:"#galeriaFD"});
    });

    $(document).on("pjax:success", function() {
        $("#idFile").on("fileuploaded", function(event) {
            $.pjax.reload({container:"#galeriaL"});
        });
        
        $("#idFile2").on("fileuploaded", function(event) {
            $.pjax.reload({container:"#galeriaFD"});
        });
    });
    
    ';
 
    $this->registerJs($js);
  ?>

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal mt-10',
            'id' => 'create-localidad-form',
            'options'=>['enctype'=>'multipart/form-data']
            
         ]
    ]); ?>

    <?= $form->field($model, 'nombre', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>   
        
    <?= $form->field($model, 'descripcion', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>
        
    <?= $form->field($model, 'admin', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?> 
    
    <?= $form->field($model, 'web', ['template' => "{label}
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
        
    <?= $form->field($model, 'direccion', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>  
          
        
    <?= $form->field($model, 'mail', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>   
   
    <?= $form->field($model, 'info_mail', ['template' => "{label}
            <div class='col-md-7'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
    ])->textInput(['maxlength' => true]) ?>  
    <div class="col-md-3  control-label"><p>Cargar Logo</p></div>     
    <div class="col-md-7  ">
        <br>
        <?php 
        echo FileInput::widget([
                        'model' => $model,
                        'attribute' => 'files[]',
                        'options'=>[
                                        'multiple'=>false,
                                        'accept'=>'image/*',
                                        'id'=>"idFile",

                        ],
                        'pluginOptions' => [
                                        'uploadUrl' => Url::to(['/laboratorio/logo']),
                                        'layoutTemplates'=>[
                                                'preview'=>'<div class="file-preview {class}">' .
                                                '    {close}' .
                                                '    <div class="{dropClass}">' .
                                                '    <div class="file-preview-thumbnails">' .
                                                '    </div>'.
                                                '    <div class="clearfix"></div>' .
                                                '    <div class="file-preview-status text-center text-success"></div>' .
                                                '    </div>' .
                                                '</div>',
                                             ],										
                        ],

                  ]);
        ?>
        <br>
    </div>
    <div class="row">
        <br>
        <?php Pjax::begin(['id' => 'galeriaL', 'enablePushState' => TRUE]); ?>
        <div class="content-galeria">
        
            <?php //Muestra el logo
                if (!empty( $model->web_path)){
                    echo $this->render('galeria', [
                        'path' => $model->web_path
                    ]);
                }
            ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
   
    <div class="col-md-3  control-label" style="margin-top:5px; "><p>Firma Digital</p></div>     
    <div class="col-md-7">
        <?php 
        echo FileInput::widget([
                        'model' => $model,
                        'attribute' => 'files[]',
                        'options'=>[
                                        'multiple'=>false,
                                        'accept'=>'image/*',
                                        'id'=>"idFile2",

                        ],
                        'pluginOptions' => [
                                        'uploadUrl' => Url::to(['/laboratorio/firmadigital']),
                                        'layoutTemplates'=>[
                                                'preview'=>'<div class="file-preview {class}">' .
                                                '    {close}' .
                                                '    <div class="{dropClass}">' .
                                                '    <div class="file-preview-thumbnails">' .
                                                '    </div>'.
                                                '    <div class="clearfix"></div>' .
                                                '    <div class="file-preview-status text-center text-success"></div>' .
                                                '    </div>' .
                                                '</div>',
                                             ],										
                        ],

                  ]);
        ?>
    </div>

    <?php Pjax::begin(['id' => 'galeriaFD', 'enablePushState' => TRUE]); ?>
    <div class="content-galeria">
        <?php //muestra la firma
            if (!empty($model->web_path_firma)){
                echo $this->render('galeria', [
                    'path' => $model->web_path_firma
                ]);
            }
        ?>
    </div>
    <?php Pjax::end(); ?>

    <div class="box-footer" >
        <div class="pull-right box-tools">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>         
    </div>

    <?php ActiveForm::end(); ?>


