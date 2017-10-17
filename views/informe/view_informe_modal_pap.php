<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Informe */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

        <div class="verLABnet">  

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [ 
                    'material',
                    'calidad',
                    'aspecto',
                    'flora',
                    'leucositos',
                    'hematies',
                    'otros',
                    'microorganismos',
                    'observaciones',
                    'diagnostico',
                    'citologia',
                   
                  
                    [
                        'label' => 'Estado',
                        'value' => $model->WorkflowLastStateName,
                    ]
                    ],
                ]) ?>

        </div>

