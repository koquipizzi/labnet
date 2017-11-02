<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Update') .' '. $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<section id="page-content">
    <div class="box box-info">
                <div class="box-header with-border">
                 <div class="pull-right">
                        <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['user/index'],['class'=>'btn btn-primary']) ?>
                    </div>
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <?= $this->render('_form', [
                        'model' => $model,

                    ]) ?>
    </div>

</section>
