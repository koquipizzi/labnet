<?php
//var_dump($model->estudio_id); die();

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use yii\web\JsExpression;
use execut\widget\TreeView;
use app\controllers\AutoTextTreeController;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Workflow;
use kartik\editable\Editable;
use kartik\popover\PopoverX;

//Pjax::begin([
//    'id' => 'pjax-container',
//]);

echo \yii::$app->request->get('page');

//Pjax::end();
/*
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
$estudio = $model->estudio_id;
$estudio = 2;
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

*/
?>
<div class="panel-body no-padding">

    <?php 
        $url= Yii::$app->getUrlManager()->createUrl('textos/customtext') ;
        $form = ActiveForm::begin([             
            'action' =>$url,
            'options' => [
                'class' => 'form-horizontal mt-10',
                'id' => 'create-autotexto-form',               
                'enableAjaxValidation' => true,
                'data-pjax' => '',
             ]
        ]); ?>

       <?php //die($model->estudio_id);
    

          
            $data=ArrayHelper::map(\app\models\Estudio::find()->asArray()->all(), 'id', 'nombre');   
            
            echo $form->field($model, 'estudio_id', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",  'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
                ])->widget(select2::classname(), [
                            'data' => $data,
                            'disabled' => true,
                            'language'=>'es',
                            'options' => ['placeholder' => 'Seleccione un tipo de Estudio ...'],
                            'pluginOptions' => [
                                'allowClear' => false
                                ],
                            ])->error([ 'style' => ' margin-right: 30%;']);
                            
                            ?>
    
        
        <?= $form->field($model, 'codigo', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'material', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'tecnica', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'macro', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6])->label('Citología Oncológica') ?> 
    
    
    <?= $form->field($model, 'diagnos', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'observ', ['template' => "{label}
            <div class='col-md-9'>{input}</div>
            {hint}
            {error}",
            'labelOptions' => [ 'class' => 'col-md-2  control-label' ]
    ])->textarea(['rows' => 6]) ?>
    <?php
              echo $form->field($model, 'estudio_id')->hiddenInput(['value'=> $model->estudio_id])->label(false);
    ?>

    <div class="form-footer">
        <div class="col-sm-offset-3">
            <div style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary enviar_autotexto' : 'btn btn-primary enviar_autotexto']) ?>
             <button type="reset" class="btn btn-danger">Restablecer</button>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
