<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use xj\bootbox\BootboxAsset;
BootboxAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\LocalidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Localidades');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/assets/admin/js/cipat_modal_localidad.js');
?>
    <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nueva Localidad', ['localidad/create'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>


    <?php Pjax::begin(['id' => 'localidad', 'enablePushState' => FALSE]); ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options'=>array('class'=>'table table-striped table-lilac'),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//                [
//                    'label' => 'Nombre',
//                    'format' => 'raw',
//                    'value' => function ($data, $url) { //var_dump($data); die();
//                                  return Html::a($data->nombre, FALSE, ['class' => 'editar', 'value'=>'index.php?r=localidad/update&id='.$data->id]);
//                              },
//                ],
          //      'id',
                'nombre',
                'cp',
                'caracteristica_telefonica',

                ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {edit} {delete}',
                'buttons' => [

                //view button
                'view' => function ($url, $model) {
                    return Html::a('<span class="fa fa-eye "></span>', $url, [
                                'title' => Yii::t('app', 'View'),
                                'class'=>'btn btn-success btn-xs ver',
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
                return  Html::a('<span  class="fa fa-trash"></span>', $url,
                        [
                          'class'=>'btn btn-danger btn-xs',
                          'onclick' => "bootbox.dialog({
                              message: '¿Confirma que desea eliminar la Localidad?',
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
                                                 alert('No se puede eliminar esa entidad.');
                                            }
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#localidad'});
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
                $url ='index.php?r=localidad/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=localidad/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=localidad/delete&id='.$model->id;
                return $url;
                }
            }
                    ],

            ],
        ]); ?>

    <?php

    Pjax::end(); ?>

    </div>

    </div>
