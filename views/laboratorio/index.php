<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Laboratorios');
$this->params['breadcrumbs'][] = $this->title;
?>

 <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Datos Generales de <?= Html::encode($this->title) ?></h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-pencil"></i> Modificar', ['update', 'id' => 1], ['class' => 'btn btn-primary']) ?>
            </div>   
            <div class="clearfix"></div>
        </div>

        <?php Pjax::begin(); ?>   
         <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options'=>array('class'=>'table table-striped table-lilac'),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'nombre',
                    'descripcion',
                    'admin',
                    'path_logo',
                    // 'ubicacion',
                    // 'mail',
                    // 'info_mail',

                 //   ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
</div>