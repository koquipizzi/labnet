<?php

use yii\helpers\Html;



$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Laboratorio',
]) . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laboratorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="box box-info">
            <div class="box-header ">
             <div class="pull-right">
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['laboratorio/index'],['class'=>'btn btn-primary']) ?>
                </div>          
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
         
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>       
</div>            
 