<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Informe */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

        <div class="verLABnet">  

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                    'material',
                    'tecnica',
                    'macroscopia',
                    'microscopia',
                    'diagnostico',
                    'observaciones',

                    [
                        'label' => 'Estado',
                        'value' => $model->WorkflowLastStateName,
                    ]
                    ],
                ]) ?>

        </div>

