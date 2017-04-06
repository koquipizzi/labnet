<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Paciente',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="box box-info">
    <div class="box-header with-border">
             <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['paciente/index'],['class'=>'btn btn-primary']) ?>
            </div>
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>

                <?= $this->render('_form', [
                    'model' => $model,
                    'dataLocalidad'=>$dataLocalidad,
                    'dataTipoDocumento'=>$dataTipoDocumento,
                    'dataPrestadoras'=> $dataPrestadoras,
                    'pacientePrestadora'=> $pacientePrestadora,
                    'prestadoraTemp'=>$prestadoraTemp,
                ]) ?>
</div>
