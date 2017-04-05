<?php


use app\assets\admin\dashboard\DashboardAsset;
use app\assets\admin\protocolo\ProtocoloAsset;

DashboardAsset::register($this);
ProtocoloAsset::register($this);

use yii\bootstrap\Modal;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;
//yii fue sustituido por
use kartik\select2\Select2;



//Models
use app\models\Estudio;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use app\models\Medico;
use app\models\ViewPacientePrestadora;
use app\models\ViewPacientePrestadoraQuery;
use app\models\Prestadoras;

/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Html::csrfMetaTags() ?>


<div class="protocolo-form">
    <div class="panel-body no-padding">
        <?php $form = ActiveForm::begin([
             'id'  => 'form-protocolo',
            'enableClientValidation' => true,
            'enableAjaxValidation'=> true,
//            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'options' => [
                'class' => 'form-horizontal mt-10 form-protocolo',
                'data-pjax'=>'',
               // 'enableClientValidation' => true,
             ]
        ]); ?>
        <div class="row form-group">
                <div class="col-md-3 control-label">
                    <h4>Protocolo</h4>
                </div>
                <div class="col-md-9 control-label">
                    <div class="col-md-4">
                                <div class="col-md-6 form-group ">
                                 <?= $form->field($model, 'anio', ['template' => "
                                                         <div class='col-md-12'>{input}</div>
                                                         {hint}
                                                         {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-0  control-label' ]
                                   ])->textInput(['maxlength' => false]) ?>
                                </div>
                                <div class="col-md-5">
                                    <?= $form->field($model, 'letra', ['template' => "
                                                                <div class='col-md-12 ' placeholder='Letra'>{input}</div>
                                                                {hint}
                                                                {error}",
                                                                'labelOptions' => [ 'class' => 'col-md-0  control-label' ]
                                    ])->textInput(['maxlength' => false]) ?>
                                </div>
                    </div>


                    <div class="col-md-2">
                            <?= $form->field($model, 'nro_secuencia',['template' => "
                                                        <div class='col-md-12'>{input}</div>
                                                        {hint}
                                                        {error}",
                              ])->textInput() ?>
                    </div>
                    <div class="col-md-3">
                            <?php /*echo $form->field($model, 'registro', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-5  control-label' ]
                            ])->textInput(['maxlength' => true]);*/
                            ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'fecha_entrada',['template' => "{label}
                                                        <div class='col-md-8'>{input}</div>
                                                        {hint}
                                                        {error}",
                                                         'labelOptions' => [ 'class' => 'col-md-4  control-label' ]
                            ])->textInput() ?>

                    </div>

                </div>

        </div>
         <div class="row">
             <div class="col-lg-1"></div>
        <div class="col-lg-5">
        <?php
        $this->registerJs("
            $(document).on('ready', function () { 
                $('#id').addClass('form-control');  
                $('#id').attr({placeholder:'Buscar por Paciente, Obra Social o Nro.Afiliado. '});
            });");
        ?>
        <div class="form-group">
            <?php
                  $data=ArrayHelper::map(ViewPacientePrestadora::find()->asArray()->all(), 'id', 'nombreDescripcionNroAfiliado');

                  echo $form->field($model, 'Paciente_prestadora_id', ['template' => "{label}
                       <div class='col-md-7'>{input}</div>
                       {hint}
                       {error}",  'labelOptions' => [ 'class' => 'col-md-3  control-label' ]
                          ])->widget(select2::classname(), [
                      'data' => $data,
                      'language'=>'es',
                      'options' => ['placeholder' => 'Seleccione una prestadora ...'],
                      'pluginOptions' => [
                          'allowClear' => false,
                          'change' => function() { log("change"); },
//    "select2:opening" => "function() { log('select2:opening'); }",
//    "select2:open" => "function() { log('open'); }",
//    "select2:closing" => "function() { log('close'); }",
//    "select2:close" => "function() { log('close'); }",
//    "select2:selecting" => "function() { log('selecting'); }",
//    "select2:select" => "function() { log('select'); }",
//    "select2:unselecting" => "function() { log('unselecting'); }",
//    "select2:unselect" => "function() { log('unselect'); }"
                          ],
                              
                      ]);
            ?>


         <?php   $dataMedico=ArrayHelper::map(Medico::find()->asArray()->all(), 'id', 'nombre');
            echo $form->field($model, 'Medico_id',['template' => "{label}
                            <div class='col-md-7'>{input}</div>
                            {hint}
                            {error}",
                        'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                         //'options' => ['placeholder' => 'Medicos'],
                ])->dropDownList(
                $dataMedico,
                ['id'=>'nombre'],
                [ 'class' => ' chosen-container chosen-container-single chosen-container-active' ]
            );
        ?>
        <?php   $dataProcedencia=ArrayHelper::map(Procedencia::find()->asArray()->all(), 'id', 'descripcion');
            echo $form->field($model, 'Procedencia_id',['template' => "{label}
                            <div class='col-md-7'>{input}</div>
                            {hint}
                            {error}",
                        'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                ])->dropDownList(
                $dataProcedencia,
                ['id'=>'descrsipcion'],
                [ 'class' => ' chosen-container chosen-container-single chosen-container-active' ]
            );
        ?>
         <?= Html::hiddenInput ('tanda', $tanda, ['id'=>'hiddenInformeTemp'])?>

        <?php
            $dataFacturar=ArrayHelper::map(Prestadoras::find()->asArray()->all(), 'id', 'descripcion');
            echo $form->field($model, 'FacturarA_id',['template' => "{label}
                            <div class='col-md-7 id='Selecmedico'>{input}</div>
                            {hint}
                            {error}",
                        'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
                ])->dropDownList(
                $dataFacturar,
                ['id'=>'descripcion'],
                [ 'class' => ' chosen-container chosen-container-single chosen-container-active' ]
            );
            ?>
            <?= $form->field($model, 'observaciones', ['template' => "{label}
                                <div class='col-md-7'   placeholder='Ingresar Observaciones'>{input}</div>
                                {hint}
                                {error}",
                                'labelOptions' => [ 'class' => 'col-md-3  control-label' ],
            ])->textArea(['maxlength' => true]) ?>

        </div>


        <div class="row" >
            <div class="col-lg-3"></div>
                <div class=" col-lg-3">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success protocoloCreate' : 'btn btn-primary protocoloCreate']) ?>
                </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

        <div class="col-lg-6">

            <!-- Start input fields - basic form -->
            <div class="panel rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">Input Fields</h3>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-sm add_estudio" data-container="body" data-action="collapse" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.panel-heading -->
                <div class="panel-body no-padding">
                    <form action="#">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label">Default Input</label>
                                <input class="form-control" type="text">
                            </div><!-- /.form-group -->
                        </div>
                        <div class="form-footer">
                            <div class="pull-right">
                                <button class="btn btn-danger mr-5">Cancel</button>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- /.form-footer -->
                    </form>

                </div><!-- /.panel-body -->
            </div><!-- /.panel -->

            <?= Html::button('Nuevo Estudio', ['value' => Url::to(['informetemp/create']), 'title' => 'Nuevo Estudio', 'class' => 'loadMainContentInformeTemp btn btn-success']); ?>
            <div class="control-label" id="estudiosInformeTemp">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'options'=>array('class'=>'table table-striped table-lilac'),
                                'toolbar' =>  [
                                    ['content'=>
                                        Html::button('&lt;i class="glyphicon glyphicon-plus">&lt;/i>', ['type'=>'button', 'title'=>'add', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
                                        Html::a('&lt;i class="glyphicon glyphicon-repeat">&lt;/i>', ['grid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'reset'])
                                    ],
                                ],
                                'columns' => [
                                    'Estudio_id',

                                    ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}{edit}{delete}',
                                    'buttons' => [

                                    //view button
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="fa fa-eye "></span>', $url, [
                                                    'title' => Yii::t('app', 'View'),
                                                    'class'=>'btn btn-success btn-xs',
                                        ]);
                                    },
                                     'edit' => function ($url, $model) {
                                        return Html::a('<span class="fa fa-pencil"></span>', $url, [
                                                    'title' => Yii::t('app', 'Editar'),
                                                    'class'=>'btn btn-info btn-xs',
                                        ]);
                                    },
                                     'delete' => function ($url, $model) {
                                        return Html::a('<span class="fa fa-trash"></span>', $url, [
                                                    'title' => Yii::t('app', 'Borrar'),
                                                    'class'=>'btn btn-danger btn-xs',
                                        ]);
                                    },
                                ],


                              ],
                                 ],
                            ]); ?>

                </div>


            </div>
        </div>
      </div>
      </div>



