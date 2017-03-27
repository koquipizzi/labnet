<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialPaciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-paciente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'fecha_entrada')->textInput() ?>

    <?= $form->field($model, 'anio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'letra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nro_secuencia')->textInput() ?>

    <?= $form->field($model, 'registro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Medico_id')->textInput() ?>

    <?= $form->field($model, 'Procedencia_id')->textInput() ?>

    <?= $form->field($model, 'Paciente_prestadora_id')->textInput() ?>

    <?= $form->field($model, 'FacturarA_id')->textInput() ?>

    <?= $form->field($model, 'fecha_entrega')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observaciones_informe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'material')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tecnica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'macroscopia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'microscopia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diagnostico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Informecol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Estudio_id')->textInput() ?>

    <?= $form->field($model, 'Protocolo_id')->textInput() ?>

    <?= $form->field($model, 'edad')->textInput() ?>

    <?= $form->field($model, 'leucositos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'aspecto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hematies')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'microorganismos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nro_documento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sexo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Tipo_documento_id')->textInput() ?>

    <?= $form->field($model, 'Localidad_id')->textInput() ?>

    <?= $form->field($model, 'domicilio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descipcion_procedencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domicilio_procedencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Localidad_id_precedencia')->textInput() ?>

    <?= $form->field($model, 'telefono_procedencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'informacion_adicional')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre_medico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_medico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domicilio_medico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono_medico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Localidad_id_medico')->textInput() ?>

    <?= $form->field($model, 'notas_medico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'especialidad_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
