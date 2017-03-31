<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TextosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//use app\assets\admin\dashboard\DashboardAsset;
//DashboardAsset::register($this);

$this->title = Yii::t('app', 'AutoTextos');
$this->params['breadcrumbs'][] = $this->title;

?>
 <section id="page-content">
    <div class="header-content">
        <h2><i class="fa fa-home"></i>LABnet <span><?= Html::encode($this->title) ?></span></h2>   
    </div><!-- /.header-content -->
    
    <div class="body-content animated fadeIn" >    
    <div class="prestadoras-index">
        <div class="panel_titulo">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="pull-right">
                    <?= Html::a(Yii::t('app', 'Nuevo AutoTexto'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>   
                <div class="clearfix"></div>
            </div>
        </div>
    <p>
        
    </p>
<?php Pjax::begin(['id'=>'autotextos']); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'codigo',
            'material:ntext',
            'diagnos:ntext',
         //   'macro:ntext',
            ['class' => 'yii\grid\ActionColumn', 
                'template' => '{view}{edit}{copy}{delete}',
                'buttons' => [

                //view button
                'view' => function ($url, $model) {
                    return Html::a('<span class="fa fa-eye "></span>', $url, [
                                'title' => Yii::t('app', 'View'),
                                'class'=>'btn  btn-xs ver', 
                                'value'=> "$url",
                    ]);
                },
                'edit' => function ($url, $model) {
                    return Html::a('<span class="fa fa-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'Editar'),
                                'class'=>'btn  btn-xs editar', 
                                'value'=> "$url",
                    ]);
                },
                        
                'copy' => function ($url, $model) {
                    return Html::a('<span class="fa fa-copy"></span>', $url, [
                                'title' => Yii::t('app', 'Copiar'),
                                'class'=>'btn btn-xs copiar', 
                                'value'=> "$url",
                    ]);
                },        

                'delete' => function ($url, $model) {
                return  Html::a('<span  class="fa fa-trash"></span>', false, 
                        [
                          'class'=>'btn btn-xs',       
                          'onclick' => "bootbox.dialog({
                              message: '¿Confirma que desea eliminar el AutoTexto?',
                              title: 'Sistema LABnet',
                              className: 'modal-info modal-center',
                              buttons: {
                                  success: {
                                      label: 'Aceptar',
                                      className: 'btn-primary',
                                      callback: function() {
                                        $.ajax('$url', {
                                            type: 'POST',
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                // alert('No se puede eliminarfff esa entidad.');                                    
                                            }
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#autotextos'});
                                            var n = noty({
                                                text: 'Entidad eliminada con éxito!',                               
                                                type: 'success',
                                                class: 'animated pulse',
                                                layout      : 'topRight',
                                                theme       : 'relax',
                                                timeout: 2000, // delay for closing event. Set false for sticky notifications
                                                force: false, // adds notification to the beginning of queue when set to true
                                                modal: false, // si pongo true me hace el efecto de pantalla gris
                                         //       maxVisible  : 10
                                            });
                                        });                                        
                                      }
                                  },
                                  cancel: {
                                      label: 'Cancelar',
                                      className: 'btn-danger',                                     
                                  }                                  
                                }
                            });
                          return false;
                          "
                            ]);
            }

        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=textos/view&id='.$model->id;
                return $url;
                }
            if ($action === 'copy') {
                $url ='index.php?r=textos/create&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=textos/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=textos/delete&id='.$model->id;
                return $url;
                }
            }
                    ],
                
            ],
        ]);  ?>
<?php Pjax::end(); ?></div>
   
        
    </div>   

   <!-- Start footer content -->
    <?php echo $this->render('/shares/_footer_admin') ;?>
    <!--/ End footer content -->
</section>

