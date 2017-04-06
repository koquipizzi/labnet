<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */

$this->title = Yii::t('app', 'Create Procedencia');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procedencias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
</div>
