<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Create Paciente');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
              <div class="pull-right">
                            <?= Html::a('<i class="fa fa-pencil"></i> Volver', ['paciente/index'], ['class'=>'btn btn-primary']) ?>
              </div>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
                'dataLocalidad'=>$dataLocalidad,
                'dataTipoDocumento'=>$dataTipoDocumento,
                'dataPrestadoras'=> $dataPrestadoras,
                'pacientePrestadora'=> $pacientePrestadora,
                'prestadoraTemp'=>$prestadoraTemp,
                'tanda' => $tanda,
            ]) ?>
</div>
