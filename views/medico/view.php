<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
    use yii\grid\GridView;
    use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Medico */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Medicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['medico/index'], ['class'=>'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-pencil"></i> Editar ', ['medico/update', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
            </div>
    </div>
    <div class="box-body">
        <?=  DetailView::widget(['model' => $model,'attributes' => [
                        'nombre',
                        'email:email',
                        [
                        'label'=>'Especialidad',
                        'value'=>$model->getEspecialidadTexto(),
                        ],
                        'domicilio',
                        'telefono',
                         [
                        'label'=>'Localidad',
                        'value'=>$model->getLocalidadTexto(),
                        ],
                        'notas'
                         ]
                 ])
        ?>
    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode('Informes Pedidos por el Medico') ?></h3>
    </div>
    
    <div class="box-body">
        <?php
            $sqlDataProvider = $model->getInformes();
            echo GridView::widget([
                'dataProvider' => $sqlDataProvider,
                'layout' => '{items}{pager}',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Código Protocolo',
                        'attribute' => 'codigo_protocolo',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:12%;'],
                        'value'=>function ($data) {
                            return Html::a(Html::encode($data['codigo_protocolo']),Url::to(["protocolo/view/", 'id' => $data['protocolo_id']]));
                        },
                    ],
                    [
                        'attribute' => 'tipo_estudio',
                        'contentOptions' => ['style' => 'width:8%;'],
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return Html::a(Html::encode($data['tipo_estudio']),Url::to(["informe/update/", 'id' => $data['informe_id']]));
                        },
                    ],
                    [
                        'attribute' => 'fecha_protocolo',
                        'contentOptions' => ['style' => 'width:8%;'],
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                    [
                        'attribute' => 'paciente_nombre',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:22%;'],
                        'value'=>function ($data) {
                            if (!empty($data['paciente_id'])){
                                return Html::a(Html::encode($data['paciente_nombre']),Url::to(["paciente/view/", 'id' => $data['paciente_id']]));
                            }else{
                                return Html::encode($data['paciente_nombre']);
                            }
                            
                        },
                    ],
                    [
                        'attribute' => 'observaciones_administrativas'
                    ]
                ]
            
            ]);
        ?>
    </div>
</div>
