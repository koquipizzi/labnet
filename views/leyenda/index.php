<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use xj\bootbox\BootboxAsset;
BootboxAsset::register($this);
$this->title = Yii::t('app', 'legend');
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="header-content">
        <div class="pull-left">
            <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-plus-circle"></i> Nueva Leyenda', ['leyenda/create'], ['class'=>'btn btn-primary']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php Pjax::begin(['id'=>'leyendas']); ?>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options'=>array('class'=>'table table-striped table-lilac'),
            'columns' => [
                'codigo',
                'texto',
                'categoria',               
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
                            message: '¿Confirma que desea eliminar la Leyenda?. Tenga en cuenta que la leyenda puede estar asociada a multiples estudios.',
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
                                                alert('No se puede eliminar la Leyenda.');
                                        }
                                    }).done(function(data) {
                                        $.pjax.reload({container: '#leyendas'});
                                        var n = noty({
                                            text: 'Leyenda eliminada con éxito!',
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
                $url ='index.php?r=leyenda/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=leyenda/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=leyenda/delete&id='.$model->id;
                return $url;
                }
            }
                    ],

            ],
        ]); ?>
    <?php Pjax::end(); ?>
    </div>
</div>
