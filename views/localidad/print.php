<?php
use app\assets\admin\dashboard\DashboardAsset;
DashboardAsset::register($this);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LocalidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Localidads');
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="page-content">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span>dashboard & statistics</span></h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li class="active">Cipat</li>
            </ol>
        </div>
    </div><!-- /.header-content -->
    
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class=" localidad-index">

        <h4><?= Html::encode($this->title) ?></h4>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create Localidad'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
           
            'options'=>array('class'=>'table table-striped table-lilac'),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'nombre',
                'cp',

                
                
            ],
        ]); ?>
    <?php
    $this->registerJs("

$(document).on('ready pjax:success', function () {
  $('.ajaxDelete').on('click', function (e) {
    e.preventDefault();
    var deleteUrl     = $(this).attr('delete-url');
    var pjaxContainer = $(this).attr('pjax-container');
    var fila =  $(this).closest('table');
    //alert(fila);
                $.ajax({
                  url:   deleteUrl,
                  type:  'post',
                  error: function (xhr, status, error) {
                    alert('hubo un error.' 
                          + xhr.responseText);
                  }
                }).done(function (data) { debugger;
                 // $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                 $.pjax.reload({container:'#w0',timeout:1000});
                });
            
   
  });
});");
    
    Pjax::end(); ?></div>                    
    </div>              
</section>