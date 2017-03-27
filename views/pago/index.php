<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\Prestadoras;
use kartik\select2\Select2;
use vova07\select2\Widget;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EstudioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Protocolos Pagos');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    Modal::begin([
            'id' => 'modal',          
            'options' => ['tabindex' => false ],  
         //   'clientOptions' => ['backdrop' => false],
        ]);
        echo "<div id='modalContent'>"
    . "<!--img class='mr-15' src='@web/assets/global/img/loader/general/3.gif' -->"
                . "</div>";
       
            

        
?> 
<?php Modal::end(); ?>

  <?php 
  use app\assets\admin\dashboard\DashboardAsset;
    DashboardAsset::register($this);
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_contable.js', ['depends' => [yii\web\AssetBundle::className()]]);
     ?>


<section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
<div class="body-content animated fadeIn" >    
<div class="estudio-index">
    
    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="float:right;">
        <?= Html::a(Yii::t('app', 'Nuevo Pago'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>
    <?php Pjax::begin(['id'=>'trab_prot', 'enablePushState' => FALSE]); ?>
    <?php
           echo GridView::widget([
           'dataProvider' => $dataProvider,
           'options'=>array('class'=>'table table-striped table-lilac'),
           'filterModel' => $searchModel,    
           'columns' => [
                                [
                                  'label' => 'Fecha Entrada',
                                  'attribute' => 'fecha_entrada',
                                  'value' => 'fecha_entrada',
                                  'format' => ['date', 'php:d/m/Y'],
                                  'filter' => \yii\jui\DatePicker::widget([
                                      'model'=>$searchModel,
                                      'attribute'=>'fecha_entrada',
                                      'language' => 'es',
                                      'dateFormat' => 'dd/MM/yyyy',
                                  ]),
                                   'contentOptions' => ['style' => 'width:10%;'],
                                ],   
                                [
                                    'label' => 'Numero Formulario',
                                    'attribute'=>'nro_formulario', 
                                    'value' => function ($model, $key, $index, $widget){
                                            if(isset($model["nro_formulario"])){
                                                  return $model["nro_formulario"];
                                            }else{
                                                return "  - - ";
                                            }


                                     },
                                    'contentOptions' => ['style' => 'width:10%;'],
                                ],                                                
                                [
                                     'label' => 'Prestadora',
                                     'attribute' => 'Prestadoras_id',
                                     'value' => function ($model, $key, $index, $widget){
                                         $prest=Prestadoras::find()->where(["id"=>$model["Prestadoras_id"]])->one();
                                         return $prest->descripcion;

                                     },
                                     'filter' => Html::activeDropDownList($searchModel, 'Prestadoras_id', ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion'),['class'=>'form-control','prompt' => 'Seleccionar Prestadora']),
                                     'contentOptions' => ['style' => 'width:20%;'],
                                 ], 
                                [
                                    'label' => 'Importe',
                                    'attribute'=>'importe', 
                                    'contentOptions' => ['style' => 'width:20%;'],
                                ],

                       ],

            ]); 
   ?>
                                    
    <?php Pjax::end(); ?></div>
    </div>
</section>

<style>
    .summary{
        float:left;
    }

</style>
