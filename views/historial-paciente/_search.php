<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialPacienteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-paciente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha_entrada') ?>

    <?= $form->field($model, 'anio') ?>

    <?= $form->field($model, 'letra') ?>

    <?= $form->field($model, 'nro_secuencia') ?>

    <?php // echo $form->field($model, 'registro') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'Medico_id') ?>

    <?php // echo $form->field($model, 'Procedencia_id') ?>

    <?php // echo $form->field($model, 'Paciente_prestadora_id') ?>

    <?php // echo $form->field($model, 'FacturarA_id') ?>

    <?php // echo $form->field($model, 'fecha_entrega') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'observaciones_informe') ?>

    <?php // echo $form->field($model, 'material') ?>

    <?php // echo $form->field($model, 'tecnica') ?>

    <?php // echo $form->field($model, 'macroscopia') ?>

    <?php // echo $form->field($model, 'microscopia') ?>

    <?php // echo $form->field($model, 'diagnostico') ?>

    <?php // echo $form->field($model, 'Informecol') ?>

    <?php // echo $form->field($model, 'Estudio_id') ?>

    <?php // echo $form->field($model, 'Protocolo_id') ?>

    <?php // echo $form->field($model, 'edad') ?>

    <?php // echo $form->field($model, 'leucositos') ?>

    <?php // echo $form->field($model, 'aspecto') ?>

    <?php // echo $form->field($model, 'calidad') ?>

    <?php // echo $form->field($model, 'otros') ?>

    <?php // echo $form->field($model, 'flora') ?>

    <?php // echo $form->field($model, 'hematies') ?>

    <?php // echo $form->field($model, 'microorganismos') ?>

    <?php // echo $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'nombre') ?>

    <?php // echo $form->field($model, 'nro_documento') ?>

    <?php // echo $form->field($model, 'sexo') ?>

    <?php // echo $form->field($model, 'fecha_nacimiento') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'Tipo_documento_id') ?>

    <?php // echo $form->field($model, 'Localidad_id') ?>

    <?php // echo $form->field($model, 'domicilio') ?>

    <?php // echo $form->field($model, 'notas') ?>

    <?php // echo $form->field($model, 'hc') ?>

    <?php // echo $form->field($model, 'descipcion_procedencia') ?>

    <?php // echo $form->field($model, 'domicilio_procedencia') ?>

    <?php // echo $form->field($model, 'Localidad_id_precedencia') ?>

    <?php // echo $form->field($model, 'telefono_procedencia') ?>

    <?php // echo $form->field($model, 'informacion_adicional') ?>

    <?php // echo $form->field($model, 'nombre_medico') ?>

    <?php // echo $form->field($model, 'email_medico') ?>

    <?php // echo $form->field($model, 'domicilio_medico') ?>

    <?php // echo $form->field($model, 'telefono_medico') ?>

    <?php // echo $form->field($model, 'Localidad_id_medico') ?>

    <?php // echo $form->field($model, 'notas_medico') ?>

    <?php // echo $form->field($model, 'especialidad_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
