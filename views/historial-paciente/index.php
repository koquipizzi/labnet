<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorialPacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial Pacientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Historial Paciente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fecha_entrada',
            'anio',
            'letra',
            'nro_secuencia',
            // 'registro',
            // 'observaciones',
            // 'Medico_id',
            // 'Procedencia_id',
            // 'Paciente_prestadora_id',
            // 'FacturarA_id',
            // 'fecha_entrega',
            // 'descripcion',
            // 'observaciones_informe',
            // 'material',
            // 'tecnica',
            // 'macroscopia',
            // 'microscopia',
            // 'diagnostico',
            // 'Informecol',
            // 'Estudio_id',
            // 'Protocolo_id',
            // 'edad',
            // 'leucositos',
            // 'aspecto',
            // 'calidad',
            // 'otros',
            // 'flora',
            // 'hematies',
            // 'microorganismos',
            // 'titulo',
            // 'tipo',
            // 'nombre',
            // 'nro_documento',
            // 'sexo',
            // 'fecha_nacimiento',
            // 'telefono',
            // 'email:email',
            // 'Tipo_documento_id',
            // 'Localidad_id',
            // 'domicilio',
            // 'notas',
            // 'hc',
            // 'descipcion_procedencia',
            // 'domicilio_procedencia',
            // 'Localidad_id_precedencia',
            // 'telefono_procedencia',
            // 'informacion_adicional',
            // 'nombre_medico',
            // 'email_medico:email',
            // 'domicilio_medico',
            // 'telefono_medico',
            // 'Localidad_id_medico',
            // 'notas_medico',
            // 'especialidad_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
