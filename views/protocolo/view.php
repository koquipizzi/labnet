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


$this->title = $model->PacienteText.' - '.  $model->Codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    Modal::begin([
            'id' => 'modal',    
           // 'size'=>'modal-lg',
            'options' => ['tabindex' => false ],
        ]);
        echo "<div id='modalContent'></div>";
       
    ?> 
    <?php Modal::end();
    
    use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_protocolo.js', ['depends' => [yii\web\AssetBundle::className()]]);
    ?>
<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>
    </div><!-- /.header-content -->

    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="protocolo-view">
                <div class="panel">
                                <div class="panel-heading">
                                    <div class="pull-left">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                                    </div><!-- /.pull-left -->
                                    <div class="pull-right">
<!--                                        <button class="btn btn-sm" data-action="expand" data-toggle="tooltip" data-placement="top" data-title="Expand" data-original-title="" title=""><i class="fa fa-expand"></i></button>
                                        <button class="btn btn-sm" data-action="refresh" data-toggle="tooltip" data-placement="top" data-title="Refresh" data-original-title="" title=""><i class="fa fa-refresh"></i></button>
                                        <button class="btn btn-sm" data-action="collapse" data-toggle="tooltip" data-placement="top" data-title="Collapse" data-original-title="" title=""><i class="fa fa-angle-up"></i></button>
                                        <button class="btn btn-sm" data-action="remove" data-toggle="tooltip" data-placement="top" data-title="Remove" data-original-title="" title=""><i class="fa fa-times"></i></button>
                                    -->
                                    <?php                            
                                $url = 'index.php?r=paciente/buscar';
                                echo Html::a('<i class="fa fa-arrow-circle-left"></i> Volver', $url, [
                                            'title' => Yii::t('app', 'Volver '),
                                            'class'=>'btn btn-primary btn-sm', 
                                           
                                ]);
                            ?>
                                    
                                    </div><!-- /.pull-right -->
                                    <div class="clearfix"></div>
                                </div><!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                    
                                    <div class="col-md-6 col-sm-6">
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' =>
                                            [

                                                [
                                                    'label'=>'Fecha de Entrega',
                                                    'value'=>$model->getFechaEntrega(),
                                                ],
                                                [
                                                    'label'=>'Médico',
                                                    'value'=>$model->medico->nombre
                                                ],

                                                [
                                                    'label'=>'Procedencia',
                                                    'value'=>$model->procedencia->descripcion
                                                ],
                                                'observaciones',
                                            ],
                                    ]) ?>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <?= $this->render('//protocolo/_gridInforme', [
                                            'dataProvider' => $dataProvider,'model'=>$model,
                                       ]) ?>  
                                    </div>
                                    </div>
                                </div><!-- /.panel-body -->
                            </div>
                
            </div>
        </div>
    </div>
</section>


