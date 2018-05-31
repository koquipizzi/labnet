<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
    use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = "Paciente: ".$model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pacientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];

$js = <<<JS

    $(document).ready(function() {
       $('.summary').hide();
    })
  
JS;
//$this->registerJs($js);

?>
<div class="row">
    <div class="col-xs-7">
        <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                    <div class="pull-right">
                        <?= Html::a('<i class="fa fa-pencil"></i> Editar ', ['paciente/update', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' =>
                            [
                                'nombre',
                                'nro_documento',
                                [
                                    'label'=>'Género',
                                    'value'=>$model->getGeneroTexto(),
                                ],
                                [
                                    'attribute' => 'fecha_nacimiento',
                                    'format' => ['date', 'php:d/m/Y']
                                ],
                                'telefono',
                                'email:email',
                                'domicilio',
                                [
                                    'label'=>'Localidad',
                                    'value'=>$model->getLocalidadTexto(),
                                ],
                                'notas',
                            ],
                    ])
                    ?>
            </div>
        </div>
    </div>
    <div class="col-xs-5">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode('Prestadoras') ?></h3>
            </div>
            <div class="box-body">
                <?php
                    $pacientesPrestadora = $model->getPacientePrestadoraDP();
                    if (!empty($pacientesPrestadora)){
                        echo GridView::widget([
                            'dataProvider' => $pacientesPrestadora,
                            'layout' => '{items}{pager}',
                            'columns' => [
                                [
                                    'label' => 'Prestadora',
                                    'attribute' => 'Prestadoras_id',
                                    'format' => 'raw',
                                    'value' => function($data){
                                        $prestadora = \app\models\Prestadoras::find()->where(['id' => $data['Prestadoras_id']])->one();
                                        return $prestadora->descripcion;
                    
                                    }
                                ],
                                [
                                    'label' => 'Nro Afiliado',
                                    'attribute' => 'nro_afiliado'
                                ],
                            ]
                        ]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>


<div class="box box-info">
    <div class="box-body">
        
        <h3> Informes Del Paciente </h3>
        
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
                            'label' => 'Médico Nombre',
                            'attribute' => 'medico_nombre',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                if (!empty($data['medico_id'])){
                                    return Html::a(Html::encode($data['medico_nombre']),Url::to(["medico/view/", 'id' => $data['medico_id']]));
                                }else{
                                    return Html::encode($data['medico_nombre']);
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
