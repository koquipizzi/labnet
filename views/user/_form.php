<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUploadUI;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
	<div class="panel-body no-padding">
        <?php

$form = ActiveForm::begin ( [
										'options' => [
												'class' => 'form-horizontal mt-10'
										]
								] );
								?>

	 <?=$form->field ( $model, 'username', [ 'template' => "{label}
	<div class='col-md-7'>{input}</div>
	{hint}
	{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ] ] )->textInput ( [ 'maxlength' => true ] )?>


	<?=$form->field ( $model, 'email', [ 'template' => "{label}
	<div class='col-md-7'>{input}</div>
	{hint}
	{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ] ] )->textInput ( [ 'maxlength' => true ] )?>

	<?=$form->field ( $model, 'password', [ 'template' => "{label}
	<div class='col-md-7'>{input}</div>
	{hint}
	{error}",'labelOptions' => [ 'class' => 'col-md-3  control-label' ] ] )->passwordInput ( [ 'maxlength' => true ] )?>


  <div class="col-md-3  control-label">
  	Avatar
  </div>
  <div class="col-md-7 ">
   <?php

                                        echo FileInput::widget([
                                            'model' => $model,
                                            'attribute' => 'files[]',
                                            'options' => [
                                                'multiple' => true,
                                                'accept' => 'image/*',
                                                'id' => "idFile",
                                            ],
                                            'pluginOptions' => [
                                                'uploadUrl' => Url::to(['/user/update']),
                                                'uploadExtraData' => [
                                                    'id' => $model->id,
                                                ],
                                                'layoutTemplates' => ['preview' => '<div class="file-preview {class}">' .
                                                    '    {close}' .
                                                    '    <div class="{dropClass}">' .
                                                    '    <div class="file-preview-thumbnails">' .
                                                    '    </div>' .
                                                    '    <div class="clearfix"></div>' .
                                                    '    <div class="file-preview-status text-center text-success"></div>' .
                                                    '    </div>' .
                                                    '</div>',
                                                ],
                                                'maxFileCount' => 1,
// 												        				'uploadExtraData' => new \yii\web\JsExpression("function (previewId, index) {
// 																						$('.kv-fileinput-error').addClass('hide');
// 																						}"),
//
                                            ],
                                        ]);
                                        ?>
	</div>
	<div class="clear"></div>
    <div class="form-footer">
			<div class="col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
        </div>
		</div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
