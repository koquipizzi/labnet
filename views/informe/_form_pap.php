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


//Pjax::begin([
//    'id' => 'pjax-container',
//]);
//
//echo \yii::$app->request->get('page');

//Pjax::end();

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

echo TreeView::widget([
    'data' => $items2,
    'size' => TreeView::SIZE_SMALL,
    'clientOptions' => [
        'onNodeSelected' => $onSelect,
    ],
]);


?>


         <div class="row">
            <div class="col-md-12">

                <!-- Start double tabs -->
                <div class="panel panel-tab panel-tab-double rounded shadow">
                    
                     <div class="ribbon-wrapper">
                          <?php if($model->estado_actual===Workflow::estadoEntregado()){
                                      echo ' <div class="ribbon  ribbon-shadow">'. "$model->workflowLastStateName".' </div>';
                                  }else{
                                         echo ' <div class="ribbon ribbon-teals ribbon-shadow">'. "$model->workflowLastStateName".' </div>';
                                     } 
                               ?>
                    </div>
                    <!-- Start tabs heading -->
                    <div class="panel-heading panel-labnet no-padding">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab2-1" data-toggle="tab">
                                    <i class="fa fa-file-text"></i>
                                    <div>
                                        <span class="text-strong">Detalle </span>
                                        <span>Carga de detalle del estudio</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2-2" data-toggle="tab">

                                    <i class="fa fa-image"></i>
                                    <div>
                                        <span class="text-strong">Multimedia</span>
                                        <span>Adjuntar imágenes</span>

                                    </div>
                                </a>
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
                                            ?>
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
                                                                'filledStar' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                                                'emptyStar' => '<i class="glyphicon glyphicon-plus"></i>',
                                                                'size' => 'sx',
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
                                                                    'filledStar' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                                                    'emptyStar' => '<i class="glyphicon glyphicon-plus"></i>',
                                                                    'size' => 'sx',
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
                                                    $dataAspecto = ArrayHelper::map(Leyenda::getTextoO(), 'id', 'texto');
                                                    echo $form->field($model, 'otros', ['template' => "{label}
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
                                            <div class="col-sm-4">   
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
                                            <?php Pjax::begin(['id' => 'galeria', 'enablePushState' => FALSE]); ?>    
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
                        </div>
                    </div><!-- /.panel-body -->
                    <?php Pjax::end(); ?> 
                    <!--/ End tabs content -->
                </div><!-- /.panel -->
                <!--/ End double tabs -->

            </div>
        </div><!-- /.row -->
        
<?php

$this->registerJsFile('@web/assets/admin/js/cipat_modal_informe.js', ['depends' => [yii\web\AssetBundle::className()]]);

$this->registerJsFile('@web/assets/admin/js/cipat_informe_pap.js', ['depends' => [yii\web\AssetBundle::className()]]);

$this->registerJsFile('@web/assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js', ['depends' => [yii\web\AssetBundle::className()]]);

?>