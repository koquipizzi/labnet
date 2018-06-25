<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use app\models\TipoPrestadora;
use app\models\Localidad;
use xj\bootbox\BootboxAsset;
BootboxAsset::register($this);


$this->title = Yii::t('app', 'Entidades Facturables');
$this->params['breadcrumbs'][] = $this->title;
    
    
    $js = <<<JS
    $('.borrarEntidadFacturable').click(function(e){
        e.preventDefault();
        var urlw = $(this).attr('value');
        bootbox.dialog
        ({
            message: '¿Confirma que desea eliminar la Entidad Facturable?',
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
                                   bootbox.alert('No se puede eliminar esa Entidad Facturable.');
                                }
                            }).done(function(data) {
                                if(data.rta==="ok"){
                                    $.pjax.reload({container: '#prestadoras'});
                                    var n = noty({
                                        text: 'Entidad Facturable eliminada con éxito!',
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
                <?= Html::a('<i class="fa fa-plus-circle"></i> Nueva Entidad Facturable', ['prestadoras/createfacturable'], ['class'=>'btn btn-primary']) ?>
            </div>
            <div class="clearfix"></div>
        </div>

     <?php Pjax::begin(['id' => 'prestadoras']); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options'=>array('class'=>'table table-striped table-lilac'),
                'filterModel' => $searchModel,
                //  'pjax' => true,
                'columns' => [
                   // [//'class' => 'yii\grid\SerialColumn'],
                    'descripcion',
                    [
                        'attribute'=>'telefono',
                        'contentOptions' => ['style' => 'width:10%;'],
                    ],
                    'email:email',
                    'domicilio',
                    [
                        'label' => 'Localidad',
                        'attribute'=>'Localidad_id',
                        'value'=>'nombreLoc',
                        'filter' => Html::activeDropDownList($searchModel, 'Localidad_id', ArrayHelper::map(Localidad::find()->asArray()->all(), 'id', 'nombre'),['class'=>'form-control','prompt' => 'Localidad...']),
                        
                    ],


                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{edit}{delete}',
                        'buttons' => [

                            //view button
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye activity-view-link"></span>', $url, [
                                    'title' => Yii::t('app', 'Ver'),
                                    'class'=>'btn btn-success btn-xs ',
                                    'value'=> "$url",
                                ])." ";
                            },
                            'edit' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'class'=>'btn btn-info btn-xs ',
                                    'value'=> "$url",
                                ])." ";
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span>', FALSE, [
                                    'title' => Yii::t('app', 'Borrar'),
                                    'class'=>'btn btn-danger borrarEntidadFacturable btn-xs',
                                    'value'=> "$url",
                                ])." ";
                            },
                        ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'view') {
                                    $url ='index.php?r=prestadoras/viewfacturable&id='.$model['id'];
                                    return $url;
                                                  }
                                   if ($action === 'edit') {
                                        $url ='index.php?r=prestadoras/updatefacturable&id='.$model['id'];
                                         return $url;
                                          }
                                       if ($action === 'delete') {
                                            $url ='index.php?r=prestadoras/deletefacturable&id='.$model['id'];
                                            return $url;
                                             }
                                          }
                    ],
                ],
            ]); ?>


            <?php


            Pjax::end(); ?>

<style>
    .summary{
        float:left;
    }


</style>

<?php
    $this->registerJsFile('@web/assets/admin/js/cipat_modal_prestadora.js',
    ['depends' => [yii\web\AssetBundle::className()]]);
?>
