<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\Prestadoras;
use yii\web\View;
use xj\bootbox\BootboxAsset;
BootboxAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\NomencladorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Nomencladors');
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
$(document).one("pjax:success", function() {
  $('.borrar').click(function(e){
        e.preventDefault();
        var urlw = $(this).attr('value');
        bootbox.dialog
        ({
            message: '¿Confirma que desea eliminar Nomenclador?',
            title: 'Sistema LABnet',
            className: 'modal-info modal-center',
            buttons: {
                success: {
                    label: 'Aceptar',
                    className: 'btn-primary',
                    callback: function() {
                        $.ajax(urlw, {
                                type: 'POST',
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                   bootbox.alert('No se puede eliminar esa entidad.');
                                }
                            }).done(function(data) {
                                if(data.rta==="ok"){
                                    $.pjax.reload({container: '#nomenclador'});
                                    var n = noty({
                                        text: 'Entidad eliminada con éxito!',
                                        type: 'success',
                                        class: 'animated pulse',
                                        layout: 'topRight',
                                        theme: 'relax',
                                        timeout: 2000, // delay for closing event. Set false for sticky notifications
                                        force: false, // adds notification to the beginning of queue when set to true
                                        modal: false, // si pongo true me hace el efecto de pantalla gris
                                        //       maxVisible  : 10
                                    });
                                }
                                if(data.rta==="error"){
                                    var n = noty({
                                        text: data.message,
                                        type: 'alert',
                                        class: 'animated pulse',
                                        layout: 'topRight',
                                        theme: 'relax',
                                        timeout: 2000, // delay for closing event. Set false for sticky notifications
                                        force: false, // adds notification to the beginning of queue when set to true
                                        modal: false, // si pongo true me hace el efecto de pantalla gris
                                        //       maxVisible  : 10
                                    });
                                }
                            });
                        }
                    },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger',
                        }
                }
         });
    });
});
    $('.borrar').click(function(e){
        e.preventDefault();
        var urlw = $(this).attr('value');
        bootbox.dialog
        ({
            message: '¿Confirma que desea eliminar Nomenclador?',
            title: 'Sistema LABnet',
            className: 'modal-info modal-center',
            buttons: {
                success: {
                    label: 'Aceptar',
                    className: 'btn-primary',
                    callback: function() {
                        $.ajax(urlw, {
                                type: 'POST',
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                   bootbox.alert('No se puede eliminar esa entidad.');
                                }
                            }).done(function(data) {
                                if(data.rta==="ok"){
                                    $.pjax.reload({container: '#nomenclador'});
                                    var n = noty({
                                        text: 'Entidad eliminada con éxito!',
                                        type: 'success',
                                        class: 'animated pulse',
                                        layout: 'topRight',
                                        theme: 'relax',
                                        timeout: 2000, // delay for closing event. Set false for sticky notifications
                                        force: false, // adds notification to the beginning of queue when set to true
                                        modal: false, // si pongo true me hace el efecto de pantalla gris
                                        //       maxVisible  : 10
                                    });
                                }
                                if(data.rta==="error"){
                                    var n = noty({
                                        text: data.message,
                                        type: 'alert',
                                        class: 'animated pulse',
                                        layout: 'topRight',
                                        theme: 'relax',
                                        timeout: 2000, // delay for closing event. Set false for sticky notifications
                                        force: false, // adds notification to the beginning of queue when set to true
                                        modal: false, // si pongo true me hace el efecto de pantalla gris
                                        //       maxVisible  : 10
                                    });
                                }
                            });
                        }
                    },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger',
                        }
                }
         });
    });
JS;
$this->registerJs($js);
?>


  <div class="header-content">
            <div class="pull-left">
                <h3 class="panel-title">Listado de <?= Html::encode($this->title) ?></h3>
            </div>
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nuevo Nomenclador', ['nomenclador/create'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>

<?php Pjax::begin(['id' => 'nomenclador', 'enablePushState' => true]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Código',
                'attribute'=>'servicio',
                'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'width:12%;'],
                'value' => function ($data, $url) { //var_dump($data); die();
                              return Html::a($data->servicio, FALSE, ['class' => 'editar', 'value'=>'index.php?r=nomenclador/update&id='.$data->id]);
                },
            ],
            'descripcion',
            'valor',
            'coseguro',
            [
                'label' =>'Prestadora',
                'attribute' => 'Prestadoras_id',
                'value' => function ($model) {
                    return $model->getPrestadoraTexto();
                },
                'filter' => Html::activeDropDownList($searchModel, 'Prestadoras_id', ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion'),['class'=>'form-control','prompt' => 'Prestadora...']),
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {edit} {delete}',
            'contentOptions' =>['class' => 'table_class','style'=>'width:15%;'],
            'buttons' => [
            //view button
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-eye "></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-success ver btn-xs',
                            'value'=> "$url",
                ]);
            },
             'edit' => function ($url, $model) {
                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Editar'),
                            'class'=>'btn btn-info btn-xs editar',
                            'value'=> "$url",
                ]);
            },
             'delete' => function ($url, $model) {
                return Html::a('<span class="fa fa-trash"></span>', $url , [
                            'title' => Yii::t('app', 'Borrar'),
                            'class'=>'btn btn-danger btn-xs borrar',
                            'value'=> "$url",
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=nomenclador/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=nomenclador/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=nomenclador/delete&id='.$model->id;
                return $url;
                }
            }
        ],
         ],
       
    ]); ?>
<?php Pjax::end();
 //$this->registerJsFile('@web/assets/admin/js/cipat_modal_nomenclador.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

