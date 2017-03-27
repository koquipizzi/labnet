<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Procedencia',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procedencias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
    <!-- Start body content -->
        <div class="panel rounded shadow">
            <div class="procedencia-update">
                            
                

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>


            
