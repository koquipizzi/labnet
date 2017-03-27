<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = Yii::t('app', 'Create Paciente');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



                <?= $this->render('_form', [
                    'model' => $model,
                    'dataLocalidad'=>$dataLocalidad,
                    'dataTipoDocumento'=>$dataTipoDocumento,
                    'dataPrestadoras'=> $dataPrestadoras,
                    'pacientePrestadora'=> $pacientePrestadora,
                    'prestadoraTemp'=>$prestadoraTemp,
                    'tanda' => $tanda,                
                ]) ?>
