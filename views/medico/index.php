<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use xj\bootbox\BootboxAsset;
use yii\helpers\ArrayHelper;
use app\models\Localidad; 
use app\models\Especialidad; 


BootboxAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Médicos');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/assets/admin/js/cipat_modal_medico.js', ['depends' => [yii\web\AssetBundle::className()]]);

?>

       <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Médico', ['medico/create'], ['class'=>'btn btn-primary']) ?>
            </div>   
            <div class="clearfix"></div>
        </div>
    

    <?php 

        Pjax::begin(['id'=>'medicos', 'enablePushState' => FALSE]); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
        //    ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'email:email',
             [
                'label' => 'Especialidad',
                'attribute' => 'Especialidad.nombre',
                'value'=>'especialidadTexto',          
                 'contentOptions' => ['style' => 'width:15%;'],
                'filter' => Html::activeDropDownList($searchModel, 'especialidad_id', ArrayHelper::map(Especialidad::find()->asArray()->all(), 'id', 'nombre'),['class'=>'form-control','prompt' => 'Especialidad...']),
                
            ],
            [
                'attribute' => 'domicilio',
                'contentOptions' => ['style' => 'width:12%;'],
            ],
            [
                'label' => 'Localidad',
                'attribute' => 'Localidad.nombre',
                'value'=>'localidadTexto',
                'contentOptions' => ['style' => 'width:12%;'],
                'filter' => Html::activeDropDownList($searchModel, 'Localidad_id', ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre'),['class'=>'form-control','prompt' => 'Localidad...']),
                
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {edit} {delete}',
            'buttons' => [

            //view button
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-eye "></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-success btn-xs',    
                            'value'=> "$url",
                ]);
            },
             'edit' => function ($url, $model) {
                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Editar'),
                            'class'=>'btn btn-info btn-xs ',    
                            'value'=> "$url",
                ]);
            },
             'delete' => function ($url, $model) {
                return Html::a('<span class="fa fa-trash"></span>', $url, [
                            'title' => Yii::t('app', 'Borrar'),
                            'class'=>'btn btn-danger btn-xs',   
                            'onclick' => "bootbox.dialog({
                              message: '¿Confirma que desea eliminar Médico?',
                              title: 'Sistema LABnet',
                              className: 'modal-default modal-center',
                              buttons: {
                                  success: {
                                      label: 'Aceptar',
                                      className: 'btn-primary',
                                      callback: function() {
                                        $.ajax('$url', {
                                            type: 'POST',
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                var n = noty({
                                                type: 'warning',
                                                text: 'No se puede eliminar la entidad seleccionada.',
                                                layout: 'topRight',
                                                theme: 'relax',
                                                timeout: 4000,
                                                animation: {
                                                    open: {height: 'toggle'},
                                                    close: {height: 'toggle'},
                                                    easing: 'swing',
                                                    speed: 500 // opening & closing animation speed
                                                }
                                            });                                         
                                            }
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#medicos'});
                                            var n = noty({
                                                type: 'success',
                                                text: 'Entidad eliminada con éxito!',
                                                layout: 'topRight',
                                                theme: 'relax',
                                                timeout: 3000,
                                                animation: {
                                                    open: {height: 'toggle'},
                                                    close: {height: 'toggle'},
                                                    easing: 'swing',
                                                    speed: 500 // opening & closing animation speed
                                                }
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
            },        
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=medico/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=medico/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=medico/delete&id='.$model->id;
                return $url;
                }
            }
        ],
         ],
    ]); ?>
<?php Pjax::end(); ?>

<style>
    .summary{
        float:left;
    }

</style>
