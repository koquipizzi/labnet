<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */

$this->title = Yii::t('app', 'Create Protocolo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

            <?= $this->render('_form_1', [
                            'model' => $model,
                            'searchModel' =>$searchModel ,
                            'Estudio' => $Estudio,
                            'dataProvider' => $dataProvider,
                            'informe'=>$informetemp,
                            'nomenclador'=>$nomenclador,
                            'tanda'=>$tanda,
                            'pacprest' => $pacprest,
                            'paciente'=>$paciente,
                            'prestadora'=> $prestadora
                ]) ?>                   
 

                

   