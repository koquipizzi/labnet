<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\widgets\Pjax;
//para crear los combos
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\rating\StarRating;
//models
use app\models\Leyenda;
use app\models\Workflow;
//tree
use yii\web\JsExpression;
use execut\widget\TreeView;
use app\controllers\AutoTextTreeController;
use app\components\TagEditor;

//Pjax::begin([
//    'id' => 'pjax-container',
//]);
//
//echo \yii::$app->request->get('page');

//Pjax::end();
Pjax::begin([
    'id' => 'pjax-container',
 ]);

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
    if (item.href !== location.pathname) {
        $.pjax({
            container: '#pjax-tree',
            url: item.href,
            timeout: null
        });
    }

    var otherTreeWidgetEl = $('.treeview.small').not($(this)),
        otherTreeWidget = otherTreeWidgetEl.data('treeview'),
        selectedEl = otherTreeWidgetEl.find('.node-selected');
    if (selectedEl.length) {
        otherTreeWidget.unselectNode(Number(selectedEl.attr('data-nodeid')));
    }
}
JS
);

$estudio = $model->Estudio_id;
$id = $model->id;
$query = "SELECT * FROM Textos where `estudio_id` = '".$estudio."' ";
//die($query);
$result = \app\models\Textos::findBySql($query)->all();
//var_dump($result); die();
$tree = new AutoTextTreeController();
foreach ($result as $row){
    $url = Url::to(['',  'id' => $id, 'idtexto'=> $row['id']]);
    $tree->merge($row['codigo'], $url);
}

$items2 = $tree->getTree();

$items = [
    [
        'text' => 'Parent 1',
        'href' => Url::to(['', 'page' => 'parent1']),
        'nodes' => [
            [
                'text' => 'Child 1',
                'href' => Url::to(['informe/update', 'id' => '1', 'idtexto'=> '12']),
                'nodes' => [
                    [
                        'text' => 'Grandchild 1',
                        Url::to(['informe/update', 'id' => '1', 'idtexto'=> '1'])
                    ],
                    [
                        'text' => 'Grandchild 2',
                        'href' => Url::to(['',  'id' => '1', 'idtexto'=> '15'])
                    ]
                ]
            ],
        ],
    ],
];

$this->registerCss(".treeview {
                                    float:left;
                                    width:100%;
                                    overflow-y: auto;
                                    height: 200px;}");

echo execut\widget\TreeView::widget([
    'data' => $items2,
    'size' => TreeView::SIZE_SMALL,
    'header'=> 'Seleccione Tipo de Estudio',
    'searchOptions' => [
        'inputOptions' => [
            'placeholder' => 'Buscar Estudio...'
        ],
    ],
    'clientOptions' => [
        'onNodeSelected' => $onSelect,
    ],
]);
Pjax::end();
?>


         <div class="row">
            <div class="col-md-12">

                <!-- Start double tabs -->
                <div class="panel panel-tab panel-tab-double rounded shadow">
                    
                    <!-- Start tabs heading -->
                    <div class="panel-heading panel-labnet no-padding">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab2-1" data-toggle="tab">
                                    <div>
                                       <i class="fa fa-file-text"></i>
                                        <span>Carga de detalle del estudio</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2-2" data-toggle="tab">
                                    <div>
                                        <i class="fa fa-image"></i>
                                        <span>Adjuntar imágenes</span>

                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2-3" data-toggle="tab">
                                    <div>
                                        <i class="fa fa-image"></i>
                                        <span>Observaciones</span>

                                    </div>
                                </a>
                            </li> 
                                 <li class="pull-right ">
                                <button class="btn btn-default btn-sm  mostrarTree pull-right" title="Agregar texto"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-default btn-sm  guardarTexto pull-right" value="<?= Url::to(['textos/copy']) ?>"><i class="fa fa-copy"></i></button>
                        <?php  
                                echo  Html::button("<i class='fa fa-list-alt'></i>",
                                    ['class'=>'btn btn-default btn-sm pull-right',
                                        'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/informe/printreducido','id'=>$model->id, 'estudio' => $model->Estudio_id ]) . "';",
                                        'data-toggle'=>'tooltip',
                                        'title'=>Yii::t('app', 'Informe Reducido'),
                                    ]
                                );
                         ?>
                         <?php   $url = ['informe/print', 'id' => $model->id , 'estudio' => $model->Estudio_id];
                                echo  Html::button("<i class='fa fa-file-pdf-o'></i>",
                                    ['class'=>'btn btn-default btn-sm  pull-right',
                                        'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/informe/imprimir','id'=>$model->id, 'estudio' => $model->Estudio_id ]) . "';",
                                        'data-toggle'=>'tooltip',
                                        'title'=>Yii::t('app', 'Informe Preliminar'),
                                    ]
                                );
                         ?>
                            </li> 
                            
                        </ul>
                    </div><!-- /.panel-heading -->
                    <!--/ End tabs heading -->
                    
                     <?php Pjax::begin(['id'=>'pjax-tree']); ?>
                    <!-- Start tabs content -->
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab2-1">              
                                <p>
                                <div>                                   
                                    <div class="informe-form">
                                        <div class="panel-body no-padding">                                            
                                            <?php
                                                $this->registerCss("label.col-md-1 {font-weight: bold;}");
                                                $form = ActiveForm::begin([
                                                            'id' => 'form-informe-complete',
                                                            'options' => [
                                                                'class' => 'form-horizontal',
                                                            ]
                                                ]);
                                                echo $form->field($model, 'id')->hiddenInput()->label(false); 
                                            ?>
                                             <input type="hidden" name="codigo" value="<?php if (isset($codigo)){ echo $codigo;} ?>" />
                                   
                                            <?php
                                                echo $form->field($model, 'titulo', ['template' => "{label}
                                                        <div class='col-md-12'>{input}</div><div class='clearfix'></div>
                                                        {hint}
                                                        {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-1 control-label', 'style' => 'float:left;']
                                                    ])->input(['maxlength' => true, 'rows' => 6, 'cols' => 20]);
                                            
                                                $dataMaterial = ArrayHelper::map(Leyenda::getMaterialPAP(), 'id', 'texto');
                                              echo $form->field($model, 'material', ['template' => "{label}
                                                            <div class='col-md-12'>{input}</div>
                                                            {hint}
                                                            {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-6  control-label']
                                                        ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20, 
                                                            'value'=> $dataMaterial[60]

                                                            ]);  
                                                
                                             $dataMaterial = ArrayHelper::map(Leyenda::getMTecnicaPAP(), 'id', 'texto');
                                              echo $form->field($model, 'tecnica', ['template' => "{label}
                                                            <div class='col-md-12'>{input}</div>
                                                            {hint}
                                                            {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-6  control-label']
                                                        ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20, 
                                                            'value'=>$dataMaterial[61]
                                                            ]);  
                                              
                                            ?>
                                                    <!--</div>-->

                                                    <h5 style="text-align: left; margin-left: 10px; font-weight: bold; ;">Citología Hormonal</h5>

                                                    <?php
                                                    $dataCalidad = ArrayHelper::map(Leyenda::getTextoC(), 'id', 'texto');

                                                    echo $form->field($model, 'calidad', ['template' => "{label}
                                                                <div class='col-md-7'>{input}</div>
                                                                {hint}
                                                                {error}", 'labelOptions' => [ 'class' => 'col-md-4  control-label']
                                                             ])->widget(select2::classname(), [
                                                                 'attribute'=> 'codigo',
                                                                    'data' => $dataCalidad,
                                                                    'language' => 'es',
                                                                    'options' => ['placeholder' => 'Seleccione una Leyenda'],
                                                                    'pluginOptions' => [
                                                                        'allowClear' => false
                                                                    ],
                                                        ])->error([ 'style' => ' margin-left: 40%;'])
                                                    ?>


                                                    <?php
                                                    $dataAspecto = ArrayHelper::map(Leyenda::getTextoA(), 'id', 'texto');
                                                    echo $form->field($model, 'aspecto', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}", 'labelOptions' => [ 'class' => 'col-md-4  control-label']
                                                      ])->widget(select2::classname(), [
                                                            'data' => $dataAspecto,
                                                            'language' => 'es',
                                                            'options' => ['placeholder' => 'Seleccione una Leyenda'],
                                                            'pluginOptions' => [
                                                                'allowClear' => false
                                                            ],
                                                        ])->error([ 'style' => ' margin-left: 40%;'])
                                                    ?>


                                                    <?php
                                                    $dataAspecto = ArrayHelper::map(Leyenda::getTextoF(), 'id', 'texto');
                                                    echo $form->field($model, 'flora', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}", 'labelOptions' => [ 'class' => 'col-md-4  control-label']
                                                       ])->widget(select2::classname(), [
                                                            'data' => $dataAspecto,
                                                            'language' => 'es',
                                                            'options' => ['placeholder' => 'Seleccione una Leyenda'],
                                                            'pluginOptions' => [
                                                                'allowClear' => false
                                                            ],
                                                    ])->error([ 'style' => ' margin-left: 40%;'])
                                                    ?>



                                                    <?php
//                                                     $dataleucositos = ArrayHelper::map(Leyenda::getMLeucositosPAP(), 'id', 'texto');
                                                    echo $form->field($model, 'leucositos', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-4  control-label']
                                                         ])->widget(StarRating::classname(), [
                                                             'data' => $dataAspecto, 
                                                            'pluginOptions' => [ 'showClear' => TRUE,
                                                                'step' => 1,
                                                                'stars' => 4,
                                                                'min' => 0,
                                                                'max' => 4,
                                                                'clearCaption' => 'No se presentan',
                                                                'clearButtonTitle'=>'No se presentan',
                                                                'filledStar' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                                                'emptyStar' => '<i class="glyphicon glyphicon-plus"></i>',
                                                                'size' => 'xs',
                                                                'starCaptions' => [
                                                                    0 => 'No se presentan',
                                                                    1 => 'Escasa cantidad',
                                                                    2 => 'Leve cantidad',
                                                                    3 => 'Moderada cantidad',
                                                                    4 => 'Abundante cantidad'
                                                                ],
                                                            ]
                                                     ]);
                                                    ?>

                                                    <?php
                                                    echo $form->field($model, 'hematies', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-4  control-label']
                                                         ])->widget(StarRating::classname(), [
                                                                'pluginOptions' => [ 'showClear' => TRUE,
                                                                    'step' => 1,
                                                                    'stars' => 4,
                                                                    'min' => 0,
                                                                    'max' => 4,
                                                                    'clearCaption' => 'No se presentan',
                                                                    'clearButtonTitle'=>'No se presentan',
                                                                    'filledStar' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                                                    'emptyStar' => '<i class="glyphicon glyphicon-plus"></i>',
                                                                    'size' => 'xs',
                                                                    'starCaptions' => [
                                                                        0 => 'No se presentan',
                                                                        1 => 'Escasa cantidad',
                                                                        2 => 'Leve cantidad',
                                                                        3 => 'Moderada cantidad',
                                                                        4 => 'Abundante cantidad'
                                                                    ],
                                                                ]
                                                        ]);
                                                    ?>

                                                    <?php
                                                    $dataOtros = ArrayHelper::map(Leyenda::getTextoO(), 'id', 'texto');
                                                    echo $form->field($model, 'otros', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}", 'labelOptions' => [ 'class' => 'col-md-4  control-label']
                                                      ])->widget(select2::classname(), [
                                                            'data' => $dataOtros,
                                                            'language' => 'es',
                                                            'options' => ['placeholder' => 'Seleccione una Leyenda'],
                                                            'pluginOptions' => [
                                                                'allowClear' => false
                                                            ],
                                                     ])->error([ 'style' => ' margin-left: 40%;'])
                                                    ?>






                                                    <?php
                                                    $dataAspecto = ArrayHelper::map(Leyenda::getTextoM(), 'id', 'texto');
                                                    echo $form->field($model, 'microorganismos', ['template' => "{label}
                                                            <div class='col-md-7'>{input}</div>
                                                            {hint}
                                                            {error}", 'labelOptions' => [ 'class' => 'col-md-4  control-label']
                                                       ])->widget(select2::classname(), [
                                                        'data' => $dataAspecto,
                                                            'language' => 'es',
                                                            'options' => ['placeholder' => 'Seleccione una Leyenda'],
                                                            'pluginOptions' => [
                                                                'allowClear' => false
                                                            ],
                                                        ])->error([ 'style' => ' margin-left: 40%;']);
                                                   
                                                    $this->registerCss(".form-horizontal .control-label { text-align: left;}");
                                                    
                                                    ?>
                                                    <?=
                                                    $form->field($model, 'citologia', ['template' => "{label}
                                                            <div class='col-md-12'>{input}</div>
                                                            {hint}
                                                            {error}",
                                                            'labelOptions' => [ 'class' => 'col-md-6  control-label']
                                                        ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                                    ?>

                                                    <?=
                                                    $form->field($model, 'diagnostico', ['template' => "{label}
                                                        <div class='col-md-12'>{input}</div>
                                                        {hint}
                                                        {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-1  control-label']
                                                      ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                                    ?>

                                                    <?=
                                                    $form->field($model, 'observaciones', ['template' => "{label}
                                                        <div class='col-md-12'>{input}</div>
                                                        {hint}
                                                        {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-1  control-label']
                                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                                    ?>

                                                    <?php /*echo $form->field($model, 'editorTags',['template' => "{label}
														<div class='col-md-12'>{input}</div>
														{hint}
														{error}",
                                                            'labelOptions' => [ 'class' => 'col-md-1  ']
                                                            ] )->widget(TagEditor::className(), [
                                                        'tagEditorOptions' => [
                                                            'autocomplete' => [
                                                                'source' => Url::toRoute(['tag/suggest'])
                                                            ],
                                                        ]
                                                    ])*/ ?>

                                                    <?=
                                                    $form->field($model, 'Estudio_id', ['template' => "{label}
                                                        <div class='col-md-7'>{input}</div>
                                                        {hint}
                                                        {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-3  control-label']
                                                    ])->hiddenInput()->label(false);
                                                    ?>
                                                                                                       
<!--                                                    $form->field($model, 'material', ['template' => "{label}
                                                        <div class='col-md-12'>{input}</div>
                                                        {hint}
                                                       {error}",
                                                        'labelOptions' => [ 'class' => 'col-md-1  control-label']
                                                   ])->textInput();
                                                    -->



                                                    <?= $form->field($model, 'Protocolo_id')->hiddenInput()->label(false); ?>

                                                    <?= $form->field($model, 'edad')->hiddenInput(['value' => $edad])->label(false); ?>    
                                                        <?php echo $form->field($model, 'id')->hiddenInput()->label(false); ?>
                                                    <div class="form-footer" style="text-align: right;">


                                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                                                    </div>
                                                <?php ActiveForm::end(); ?>
                                        </div>
                                    </div>
                                </div>       
                                </p>       
                            </div>


                            <div class="tab-pane fade" id="tab2-2">
                                <h4>Seleccionar imágenes</h4>
                                <p>
                                <div style="margin-top: 30px;">


                                    <div class="panel-body no-padding">
                                        <div class="row">
                                            <div class="col-sm-12">   
                                                <?php
                                                echo FileInput::widget([
                                                    'model' => $model,
                                                    'attribute' => 'files[]',
                                                    //         		'name' => 'files[]',
                                                    'options' => [
                                                        'multiple' => true,
                                                        'accept' => 'image/*',
                                                        'id' => "idFile",
                                                    ],
                                                    'pluginOptions' => [
                                                        'uploadUrl' => Url::to(['/informe/update']),
                                                        'uploadExtraData' => [
                                                            'Informe_id' => $model->id,
                                                        ],
                                                        'layoutTemplates' => ['preview' => '<div class="file-preview {class}">' .
                                                            '    {close}' .
                                                            '    <div class="{dropClass}">' .
                                                            '    <div class="file-preview-thumbnails">' .
                                                            '    </div>' .
                                                            '    <div class="clearfix"></div>' .
                                                            '    <div class="file-preview-status text-center text-success"></div>' .
                                                            '    </div>' .
                                                            '</div>',
                                                        ],
                                                        'maxFileCount' => 10,	
                                                        'allowedFileExtensions'=>['jpg','gif','png'],
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <script type="text/javascript">

// 												$("#idFile").on('fileuploaded',function(a,b,c,d){
// 															alert("p file");
// 													});
                                        </script>

                                        <h3>Imágenes del informe
                                            <span>
                                            <?php echo Html::a('<i class="fa fa-retweet"></i>', ['refresh', 'id' => $model->id], ['class' => 'refresh btn btn-success']); ?>
                                            </span>
                                        </h3>
                                        <?php Pjax::begin(['id' => 'galeriar', 'enablePushState' => FALSE]); ?>    
                                        <div class="content-galeria">
                                    
                                            <?=
                                            $this->render('galeria_1', [
                                                'model' => $model,
                                                'dataproviderMultimedia' => $dataproviderMultimedia,
                                            ])
                                            ?>
                                        </div>
                                        <?php Pjax::end(); ?>
                                    </div>
                                    <div class="form-footer">
                                        <div class="col-sm-offset-3">
                                        </div>
                                    </div>



                                    </p>
                                </div>


                            </div><!-- /End pad 2 -->
                            <div class="tab-pane fade" id="tab2-3">
                        <h4> Observaciones Administrativas </h4>
                        <p>
                        <div style="margin-top: 5px;">
                             <?php
                              $hid =   "<input type=\"hidden\" name=\"id_informe\" value=\"".$model->id."\">";
                              $formObs = ActiveForm::begin([
                                                'id' => 'form-informe-observaciones',
                                                'options' => [
                                                    'class' => 'form-horizontal'
                                                ]
                                    ]);

                                     echo  $formObs->field($modelp, 'observaciones', ['template' => "
                                                <div class='col-md-12'>{input}</div>
                                                {hint}
                                                {error}"
                                            ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);     
                                ?>
                                <?= $formObs->field($model, 'id')->hiddenInput()->label(false); ?>

                                <div class="form-footer">
                                    <div style="text-align: right;">
                                        <?= Html::submitButton($modelp->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelp->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>  
                        </div>
                        </p>
                    </div>          
                        </div>
                    </div><!-- /.panel-body -->
                    <?php Pjax::end(); ?> 
                    <!--/ End tabs content -->
                </div><!-- /.panel -->
                <!--/ End double tabs -->
                
                <?php echo \yii2mod\comments\widgets\Comment::widget([
                    'model' => $model,
                    //  'formId' => 'comment-form2',
                    'pjaxContainerId' => 'unique-pjax-container-id'
                ]); ?>

            </div>
        </div><!-- /.row -->
        
<?php

$this->registerJsFile('@web/assets/admin/js/cipat_modal_informe.js', ['depends' => [yii\web\AssetBundle::className()]]);

//$this->registerJsFile('@web/assets/admin/js/cipat_informe_pap.js', ['depends' => [yii\web\AssetBundle::className()]]);

$this->registerJsFile('@web/assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js', ['depends' => [yii\web\AssetBundle::className()]]);

?>