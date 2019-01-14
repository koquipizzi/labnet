<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

use \app\models\Informe;
/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */
//var_dump($model); die();

$this->title = $model->Codigo .' - '.$model->pacienteTexto;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>           
        <div class="pull-right">
            <?php 
               $url = Url::to(['post/view', 'id' => 100]);
            ?>
            <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', Yii::$app->request->referrer, ['class'=>'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-pencil"></i> Editar ', ['protocolo/update', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
        </div>                                                              
    </div>
    <div class="panel-body">
        <div class="row">                   
            <div class="col-md-12 col-sm-12">  
                <?php   
                    echo !empty($mostrarMensajeView) ?  "<div style='background-color:LightGoldenrodYellow;' ><p style='font-style: italic;'>". $mostrarMensajeView. "</p> <div>" : "";
                ?> 
            </div>    
        </div>              
        <div class="row">                   
            <div class="col-md-4 col-sm-4">              
            <?= DetailView::widget([
                'model' => $model,
                'attributes' =>
                    [
                        [
                            'label'=>'Fecha de Entrada',
                            'value'=>$model->getFechaEntradaformateada(),
                        ],      
                        [
                            'label'=>'Fecha de Entrega',
                            'value'=>$model->getFechaEntregaformateada(),
                        ],                  
                        [
                            'label'=>'Médico',
                            'value'=>$model->medico->nombre
                        ],

                        [
                            'label'=>'Procedencia',
                            'value'=>$model->procedencia->descripcion
                        ],

                        [
                            'attribute'=>'Cobertura',
                            'value'=>$model->getCobertura()
                        ],    
                        [
                            'attribute'=>'Facturar A',
                            'value'=>$model->getNombreFacturarA()
                        ],                                                
                        
                        'numero_hospitalario',
                        'observaciones',
                    ],
            ]) ?>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Estudios</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <?= $this->render('//protocolo/_gridInforme', [
                                'dataProvider' => $dataProvider,'model'=>$model,
                        ]) ?> 
                    </div>
                </div> 
            </div>    
    </div>
            
</div><!-- /.panel-body -->
          
   