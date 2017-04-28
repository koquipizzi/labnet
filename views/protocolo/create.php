<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */

$this->title = Yii::t('app', 'Create Protocolo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">

            <?= $this->render('_form_1', [
                            'model' => $model,
                            'searchModel' =>$searchModel ,
                            'Estudio' => $Estudio,
                            'dataProvider' => $dataProvider,
                            'informe'=>$informe,
                            'nomenclador'=>$nomenclador,
                            'tanda'=>$tanda,
                            'pacprest' => $pacprest,
                            'paciente'=>$paciente,
                            'prestadora'=> $prestadora
                ]) ?>



</div>
