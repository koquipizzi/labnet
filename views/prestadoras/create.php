<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */

$this->title = Yii::t('app', 'Create Prestadoras');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="prestadoras-create">
                <div class="panel-heading">
                                   <div class="pull-left">
                                       <h3 class="panel-title"><?= Html::encode($this->title) ?><code></code></h3>
                                   </div>
                                   <div class="clearfix"></div>
                </div><!-- /.panel-heading -->

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
