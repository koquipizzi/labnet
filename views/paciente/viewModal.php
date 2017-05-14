<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = "Paciente: ".$prest_nro;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
use app\models\PacientePrestadora;
$afiliadoA = PacientePrestadora::find()->where(['Paciente_id' => $model->id]);
//var_dump($prest_nro); die();
//if (!isset($prest_nro))
  //  echo $prest_nro;  die();
  
?>
<div class="box box-info">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' =>
                    [
                        'nombre',
                        'nro_documento',
                        [
                            'label'=>'Género',
                            'value'=>$model->getGeneroTexto(),
                        ],
                        [
                            'attribute' => 'fecha_nacimiento',
                            'format' => ['date', 'php:d/m/Y']
                        ],
                        'telefono',
                        'email:email',
                        'domicilio',
                        [
                            'label'=>'Localidad',
                            'value'=>$model->getLocalidadTexto(),
                        ],

                    ],
                ]) ?>
</div>
