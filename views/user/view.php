<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>
    </div><!-- /.header-content -->

    <!-- Start body content -->
<div class="box box-info">
    <div class="box-header with-border">
       <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
           <div class="pull-right">
               <?= Html::a('<i class="fa fa-pencil"></i> Volver', ['user/index'], ['class'=>'btn btn-primary']) ?>
           </div>
   </div>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
		            'username',
		            'email:email',
                    'created_at',
                    ],
                ]) ?>
</div>
