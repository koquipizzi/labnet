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

                <?= $this->render('_form', [
                    'model' => $model,
                    'dataLocalidad'=>$dataLocalidad,
                    'dataTipoDocumento'=>$dataTipoDocumento,
                    'dataPrestadoras'=> $dataPrestadoras,
                    'pacientePrestadora'=> $pacientePrestadora,
                    'prestadoraTemp'=>$prestadoraTemp,
                ]) ?>

  
 
