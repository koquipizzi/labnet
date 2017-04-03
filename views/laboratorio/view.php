<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Laboratorio */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laboratorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                    <?= Html::a(Yii::t('app', 'Modificar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </div>                                                          
            </div>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [                        
                        'nombre',
                        'descripcion',
                        'admin',
                       // 'path_logo',
                        'direccion',
                        'web',
                        'telefono',
                        'mail',
                        'info_mail',
                    ],
                ]) ?>

    </div>

