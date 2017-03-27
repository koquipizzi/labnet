<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */

$this->title = Yii::t('app', 'Create Protocolo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <?= $this->render('_form_2', [
                            'model' => $model,
                            'searchModel' =>$searchModel ,
                            'Estudio' => $Estudio,
                            'dataProvider' => $dataProvider,
                            'informe'=>$informetemp,
                            'nomenclador'=>$nomenclador,
                            'tanda'=>$tanda
                ]) ?>                   
</div>            
         

                

   