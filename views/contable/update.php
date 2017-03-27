<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estudio */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Estudio',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estudios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
    use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);

$this->registerJsFile('@web/assets/admin/js/cipat_modal_informe.js', ['depends' => [yii\web\AssetBundle::className()]]);

    $this->registerJsFile('@web/assets/admin/js/cipat_modal_nomenclador.js', ['depends' => [app\assets\admin\dashboard\DashboardAsset::className()]]);
   
$this->registerJsFile('@web/assets/admin/js/cipat_modal_contable.js', ['depends' => [yii\web\AssetBundle::className()]]);

?>

<section id="page-content">


    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="informe-update">
                <div class="panel-heading">
                                   <div class="pull-left">
                                       <h3 class="panel-title"><?= Html::encode($model->getNameEstudio($model->Estudio_id)) ?><code></code></h3>
                                   </div>
                                   <div class="pull-right">
                                       <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                                       <button class="btn btn-sm" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Remove"><i class="fa fa-times"></i></button>
                                   </div>
                                   <div class="clearfix"></div>
                </div><!-- /.panel-heading -->                 
                 <div class="table-responsive">
                    <table class="table">
                        <tbody>  
                        <tr>
                            <td>
                                <span class="pull-left text-capitalize">Paciente</span>
                            </td>
                            <td>
                                <span class="pull-left text-strong"><?= $modelp->pacienteText ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pull-left text-capitalize">Procedencia</span>
                              </td>
                            <td>   <span class="pull-left text-strong"><?= $modelp->procedencia->descipcion ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pull-left text-capitalize">Facturar a</span>
                             </td>
                            <td>
                                <span class="pull-left text-strong"><?= $modelp->facturarA->descripcion ?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                 </div>
               

            </div>

        </div>
    </div>
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="nomenclador-update">

                <?php
                     echo $this->render('//nomenclador/_nomencladores', [
                                        'model' => $model, 
                                        'informe'=>$informe, 
                                        'dataProvider'=> $dataProvider,
                                        'modeloInformeNomenclador' => $modeloInformeNomenclador
                                      ]) ;

                ?>
            </div>

        </div>
    </div>
</section>
            