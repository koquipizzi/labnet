<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Informe */

$this->title = "Estudio ".$model->getNameEstudio($model->Estudio_id) ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estudio'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="page-content">
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="estudio-view">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?= Html::encode($this->title) ?>
                    </h3>
                </div>

                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Código Protocolo',
                            'value' => $model->codigoProtocolo,
                        ],
                        [
                            'label' => 'Paciente',
                            'value' => $model->nombrePaciente,
                        ],
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
                ]) ;
                ?>
                <div class="row">
                    <div class="col-md-11">
                        <?php
                            $url = Url::to(['informe/view-edit-observaciones-administrativas', 'id' => $model->id]);
                            $form = ActiveForm::begin([
                                    'action' => $url
                            ]);

                            echo $form->field($model->protocolo, 'observaciones', ['template' => "{label}
                                    <div class='col-md-10'>{input}</div>                                    
                                    {hint}
                                    {error}",
                                'labelOptions' => [ 'class' => 'col-md-2  control-label','style' => 'float:left;']
                            ])->textArea(['maxlength' => true, 'rows' => 2, 'cols' => 20])->label('Observaciones Administrativas');?>
                        <div class="row">
                            <div class="col-md-12">
                                <div  style="float: right; padding-bottom: 20px; padding-top: 5px; margin-right: 15px;">
                                   <?php
                                     echo Html::submitButton($model->protocolo->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->protocolo->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                                   ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            ActiveForm::end();
                        ?>
                    </div>
                </div>
             </div>
        </div>
    </div>
</section>
