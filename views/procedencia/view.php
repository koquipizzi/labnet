<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procedencias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
       <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="pull-right">
                <?php $url ='index.php?r=procedencia/update&id='.$model->id;?>
                    <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['procedencia/index'], ['class'=>'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-pencil"></i> Editar', $url, ['class'=>'btn btn-primary']) ?>
                    
                </div>
        </div>
        <div class="verLABnet">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'descripcion',
                        'mail',
                        'domicilio',
                        [
                            'attribute'=>'Localidad',
                            'value'=> $model->getLocalidadTexto(),
                        ],
                    		'telefono'
                    ],
                ]) ?>
                

        </div>
</div>








