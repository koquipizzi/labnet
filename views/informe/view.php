<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Informe */

 $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="verLABnet">
      <?php 
      DetailView::widget([
      		'model' => $model,
      		'attributes' => [
      				'descripcion',
      				'observaciones',
      				'material',
      				'tecnica',
      				'macroscopia',
      				'microscopia',
      				'diagnostico',
      				'Protocolo_id',
      		],

]);
?>
 </div>

