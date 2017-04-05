<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Informe */
/* @var $form yii\widgets\ActiveForm */

use yii\web\JsExpression;
use execut\widget\TreeView;
use app\controllers\AutoTextTreeController;
use app\models\Workflow;

//Pjax::begin([
//    'id' => 'pjax-container',
//]);

echo \yii::$app->request->get('page');

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
                                height: 200px;
                            }             
");

echo execut\widget\TreeView::widget([
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
                            <div class="informe-form">
                                <div class="panel-body no-padding">
                                    <?php
                                    $form = ActiveForm::begin([
                                                'id' => 'form-informe-complete',
                                                'options' => [
                                                    'class' => 'form-horizontal'
                                                ]
                                    ]);
                                    echo $form->field($model, 'id')->hiddenInput()->label(false); ?>
                                    <input type="hidden" name="codigo" value="<?php if (isset($codigo)){ echo $codigo;} ?>"/>
                                    <?php
                                    if ($model->estudio->id == 4) {
                                        echo  $form->field($model, 'tipo', ['template' => "{label}
                                                <div class='col-md-12'>{input}</div>
                                                {hint}
                                                {error}",
                                                'labelOptions' => [ 'class' => 'col-md-12  ']
                                            ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo  $form->field($model, 'material', ['template' => "{label}
                                                    <div class='col-md-12'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                    'labelOptions' => [ 'class' => 'col-md-1  ']
                                                ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        echo  $form->field($model, 'tecnica', ['template' => "{label}
                                                    <div class='col-md-12'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                    'labelOptions' => [ 'class' => 'col-md-1  ']
                                                ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        echo  $form->field($model, 'descripcion', ['template' => "{label}
                                                <div class='col-md-12'>{input}</div>
                                                {hint}
                                                {error}"
                                            ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20])->label('Descripción Citológica' ,['class'=>'col-md-9']);
                                        
                                        echo $form->field($model, 'diagnostico', ['template' => "{label}
                                                    <div class='col-md-12'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                'labelOptions' => [ 'class' => 'col-md-1']
                                            ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        echo $form->field($model, 'observaciones', ['template' => "{label}
                                                    <div class='col-md-12'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                'labelOptions' => [ 'class' => 'col-md-1  ']
                                            ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    } 
                                    if ($model->estudio->id == 5) { //INMQ
                                        echo $form->field($model, 'material', ['template' => "{label}
						<div class='col-md-12'>{input}</div>
						{hint}
						{error}",
                                            'labelOptions' => [ 'class' => 'col-md-1 ']
                                         ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo  $form->field($model, 'tecnica', ['template' => "{label}
                                                    <div class='col-md-12'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                    'labelOptions' => [ 'class' => 'col-md-1  ']
                                                ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        echo $form->field($model, 'macroscopia', ['template' => "{label}
												<div class='col-md-12'>{input}</div>
												{hint}
												{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo $form->field($model, 'microscopia', ['template' => "{label}
													<div class='col-md-12'>{input}</div>
													{hint}
													{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        echo $form->field($model, 'diagnostico', ['template' => "{label}
													<div class='col-md-12'>{input}</div>
													{hint}
													{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo $form->field($model, 'observaciones', ['template' => "{label}
														<div class='col-md-12'>{input}</div>
														{hint}
														{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1  ']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        
                                        
                                        
                                    } // fin inmuno
                                    
                                    if ($model->estudio->id == 2) {
                                        echo $form->field($model, 'material', ['template' => "{label}
						<div class='col-md-12'>{input}</div>
						{hint}
						{error}",
                                            'labelOptions' => [ 'class' => 'col-md-1 ']
                                         ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo  $form->field($model, 'tecnica', ['template' => "{label}
                                                    <div class='col-md-12'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                    'labelOptions' => [ 'class' => 'col-md-1  ']
                                                ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        
                                        echo $form->field($model, 'macroscopia', ['template' => "{label}
												<div class='col-md-12'>{input}</div>
												{hint}
												{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo $form->field($model, 'microscopia', ['template' => "{label}
													<div class='col-md-12'>{input}</div>
													{hint}
													{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        echo $form->field($model, 'diagnostico', ['template' => "{label}
													<div class='col-md-12'>{input}</div>
													{hint}
													{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo $form->field($model, 'observaciones', ['template' => "{label}
														<div class='col-md-12'>{input}</div>
														{hint}
														{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1  ']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        
                                           
                                        
                                    }
                                    
                                    if ($model->estudio->id == 3) {
                                        echo $form->field($model, 'material', ['template' => "{label}
						<div class='col-md-12'>{input}</div>
						{hint}
						{error}",
                                            'labelOptions' => [ 'class' => 'col-md-1 ']
                                         ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo  $form->field($model, 'tecnica', ['template' => "{label}
                                                    <div class='col-md-12'>{input}</div>
                                                    {hint}
                                                    {error}",
                                                    'labelOptions' => [ 'class' => 'col-md-1  ']
                                                ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        
                                        echo $form->field($model, 'metodo', ['template' => "{label}
												<div class='col-md-12'>{input}</div>
												{hint}
												{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        
                                    
                                        echo $form->field($model, 'resultado', ['template' => "{label}
													<div class='col-md-12'>{input}</div>
													{hint}
													{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                        
                                        echo $form->field($model, 'diagnostico', ['template' => "{label}
													<div class='col-md-12'>{input}</div>
													{hint}
													{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);
                                    
                                        echo $form->field($model, 'observaciones', ['template' => "{label}
														<div class='col-md-12'>{input}</div>
														{hint}
														{error}",
                                        'labelOptions' => [ 'class' => 'col-md-1  ']
                                    ])->textArea(['maxlength' => true, 'rows' => 4, 'cols' => 20]);     
                                        
                                    }
                                    
                                    ?>

                                    <?=
                                    $form->field($model, 'Estudio_id', ['template' => "{label}
                                                            <div class='col-md-12'>{input}</div>
                                                            {hint}
                                                            {error}",
                                        'labelOptions' => [ 'class' => 'col-md-1 ']
                                    ])->hiddenInput()->label(false);
                                    ?>

                                    <?= $form->field($model, 'Protocolo_id')->hiddenInput()->label(false); ?>

                                    <?= $form->field($model, 'edad')->hiddenInput(['value' => $edad])->label(false); ?>    

                                    <div class="form-footer">
                                        <div style="text-align: right;">
                                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end(); ?>   


                                </div>
                            </div>      
                        </p>       
                    </div>


                    <div class="tab-pane fade" id="tab2-2">
                        <h4>Seleccionar imágenes</h4>
                        <p>
                        <div style="margin-top: 5px;">


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
// 												        				'uploadExtraData' => new \yii\web\JsExpression("function (previewId, index) {
// 																						$('.kv-fileinput-error').addClass('hide');
// 																						}"),
// 																		
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>

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
                </div>
            </div><!-- /.panel-body -->
            <?php Pjax::end(); ?> 
            <!--/ End tabs content -->
        </div><!-- /.panel -->
        <!--/ End double tabs -->

    </div>
</div><!-- /.row -->


