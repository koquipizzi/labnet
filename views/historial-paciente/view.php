<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialPaciente */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Historial Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-paciente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fecha_entrada',
            'anio',
            'letra',
            'nro_secuencia',
            'registro',
            'observaciones',
            'Medico_id',
            'Procedencia_id',
            'Paciente_prestadora_id',
            'FacturarA_id',
            'fecha_entrega',
            'descripcion',
            'observaciones_informe',
            'material',
            'tecnica',
            'macroscopia',
            'microscopia',
            'diagnostico',
            'Informecol',
            'Estudio_id',
            'Protocolo_id',
            'edad',
            'leucositos',
            'aspecto',
            'calidad',
            'otros',
            'flora',
            'hematies',
            'microorganismos',
            'titulo',
            'tipo',
            'nombre',
            'nro_documento',
            'sexo',
            'fecha_nacimiento',
            'telefono',
            'email:email',
            'Tipo_documento_id',
            'Localidad_id',
            'domicilio',
            'notas',
            'hc',
            'descipcion_procedencia',
            'domicilio_procedencia',
            'Localidad_id_precedencia',
            'telefono_procedencia',
            'informacion_adicional',
            'nombre_medico',
            'email_medico:email',
            'domicilio_medico',
            'telefono_medico',
            'Localidad_id_medico',
            'notas_medico',
            'especialidad_id',
        ],
    ]) ?>

</div>
