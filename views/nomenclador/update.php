<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclador */

$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => 'Nomenclador',]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nomencladors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>
    </div><!-- /.header-content -->

    <!-- Start body content -->
    <div class="box box-info">
                <div class="box-header with-border">
                             <div class="pull-right">
                                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['procedencia/index'],['class'=>'btn btn-primary']) ?>
                             </div>
                             <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <?= $this->render('_form', [
                        'model' => $model,

                    ]) ?>
    </div>

</section>
