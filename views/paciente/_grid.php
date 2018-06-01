<?php 
//use app\assets\admin\dashboard\DashboardAsset;
//DashboardAsset::register($this);

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\editable\Editable;
use kartik\popover\PopoverX;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
//para crear los combos
use yii\helpers\ArrayHelper;
//agregar modelos para los combos
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use app\models\Prestadoras;

use yii\bootstrap\Modal;
use app\models\PacientePrestadora;
?>
<?php 
    Modal::begin([
            'id' => 'modal',    
           // 'size'=>'modal-lg',
            'options' => ['tabindex' => false ],
        ]);
        echo "<div id='modalContent'></div>";
       
     Modal::end();
    ?> 

 <?php 
        $data =  Prestadoras::find()->asArray()->all();
        $data2 =  ArrayHelper::map($data, 'id', 'descripcion');

        $data = Prestadoras::find()->all();
        $data2 = ArrayHelper::map($data,'id', 'descripcion');
        
        $js =" $('.showModalButton').click( function (e) {
            $('#modal').find('.modal-header').html('Nueva Prestadora');".
            "$('#modal').find('#modalContent').load('".Url::to(['prestadoras/create_modal'])."');".
            "$('#modal').modal('show');
            });

            $('#modal').find('#modalContent').find('.addModalPrestadora').click( function (e) {
                alert('dd');
        });
        
        
        ";
        
        $this->registerJs($js);

         yii\bootstrap\Modal::begin([
        'header' => 'Update Lesson Learned',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
    ]);
        echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();

        $this->registerJs(
        "$(document).on('ready pjax:success', function() {
                $('.modalButton').click(function(e){
                   e.preventDefault(); //for prevent default behavior of <a> tag.
                   var tagname = $(this)[0].tagName;
                   $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
               });
            });
        ");

        // JS: Update response handling
        $this->registerJs(
    'jQuery(document).ready(function($){
        $(document).ready(function () {
            $("body").on("beforeSubmit", "form#lesson-learned-form-id", function () {
                var form = $(this);
                // return false if form still have some validation errors
                if (form.find(".has-error").length) {
                    return false;
                }
                // submit form
                $.ajax({
                    url    : form.attr("action"),
                    type   : "post",
                    data   : form.serialize(),
                    success: function (response) {
                        $("#editModalId").modal("toggle");
                        $.pjax.reload({container:"#lessons-grid-container-id"}); //for pjax update
                    },
                    error  : function () {
                        console.log("internal server error");
                    }
                });
                return false;
             });
            });
            });'
        );


 ?>
        <?php Pjax::begin(['id' => 'prestadoras']); ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,                                
                                'options'=>array('class'=>'table table-striped table-lilac'),
                                'summary' => '',
                                'columns' => [
                                    [
                                        'label' => 'Prestadora',
                                        'value' => 'prestadoraTexto',
                                    ],
                                    [
                                        'attribute' => 'nro_afiliado',
                                        'filter' => false,
                                        'format' => 'raw',
                                        'value' => function ($model, $data) {
                                            $url = Url::toRoute(['paciente-prestadora/update-nro-afiliado', 'id' => $model->id ]);
                                            $editable = Editable::widget([
                                                'name'=>'nro_afiliado',
                                                'asPopover' => false,
                                                'value' => $model->nro_afiliado,
                                                'format' => Editable::INPUT_TEXT,
                                                'formOptions' => [
                                                    'method' => 'post',
                                                    'action' => $url,
                                                ],
                                                'header' => FALSE,
                                                'size'=>'xs',
                                            //   'editableValueOptions'=>['class'=>'well well-sm'],
                                                'options' => ['class'=>'form-control', 'placeholder'=>'Nro de Afiliado...'],
                                            ]);
                                            return $editable;
                                        },
                                    ],
                                    ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete} {crear}',
                                    'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="fa fa-trash"></span>', FALSE, [
                                                    'title' => Yii::t('app', 'Borrar'),
                                                    'class'=>'btn btn-danger btn-xs', 
                                                    'onclick'=>'deletePrestadora('.$model->id.',"'.$url.'")', 
                                                    'value'=> "$url",
                                        ]);
                                    },
                                    'crear' => function ($url, $model) {
                                        $url = Url::toRoute(['protocolo/create3', 'pacprest' => $model->id]);
                                        return Html::a(' <span class="fa fa-arrow-right"></span> Crear Protocolo', $url, [
                                                    'title' => Yii::t('app', 'Borrar'),
                                                    'class'=>'btn bg-purple btn-flat btn-xs', 
                                                    'value'=> "$url",
                                        ]);
                                    },
                                   
                                ],

          
                              ],
                                 ],
                            ]); 
                            
                            
        ?>

        <?php Pjax::end() ?>

<?php
echo Html::button(
    'Asignar Prestadora',
    [
        'class' => 'btn btn-primary boton_addP',
        'onclick' => '$(".addP").show(); $(".boton_addP").hide();',
    ]
);
?>
        <div class="box box-primary addP" style="display:none; margin-top: 10px;">
            <div class="box-header">
                Asignar Prestadora
                <div class="box-tools pull-right">
                    <a class="btn btn-primary btn-flat btn-xs showModalButton" value="/index.php?r=prestadoras%2Fcreate" >Nueva Prestadora</a>
                </div>
            </div>
            <div class="box-body">
                
                <div class="paciente-prestadora-form">

                        <?php $form = ActiveForm::begin(['action' => Url::toRoute('/paciente-prestadora/create'),
                                                                    'id' => 'pac_prest']); ?>

                        <?= $form->field($model, 'nro_afiliado')->textInput(['maxlength' => true]) ?>

                        <?php echo $form->field($model, 'Paciente_id')->hiddenInput( array('value'=>$paciente_id))->label(false);?>

                        <?php 
                        
                            echo $form->field($model, 'Prestadoras_id')->widget(Select2::classname(), [
                                    'name' => 'kv-repo-template',
                                    'value' => '14719648',
                                    'initValueText' => 'Ingrese Prestadora',
                                    'options' => [  'placeholder' => 'Buscar Prestadora ...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'ajax' => [
                                            'url' => Url::to(['prestadoras/list']),
                                            'dataType' => 'json',
                                            'delay' => 250,
                                            'data' => new JsExpression('function(params) { return {term:params.term  }; }'),
                                            'processResults' => new JsExpression('function(data) {
                                                return {
                                                    results: $.map(data, function(item, index) {
                                                        return {
                                                        "id": item.id,
                                                        "text": item.descripcion 
                                                        };
                                                    })
                                                    };
                                                }'),
                                        
                                            'cache' => true
                                        ],
                                    ],
                            ]);
                        

                      /*      echo Select2::widget([
                                    'name' => 'kv-repo-template',
                                    'value' => '14719648',
                                    'initValueText' => 'Ingrese Prestadora',
                                    'options' => [  'placeholder' => 'Buscar Prestadora ...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'ajax' => [
                                            'url' => Url::to(['prestadoras/list']),
                                            'dataType' => 'json',
                                            'delay' => 250,
                                            'data' => new JsExpression('function(params) { return {term:params.term  }; }'),
                                            'processResults' => new JsExpression('function(data) {
                                                return {
                                                    results: $.map(data, function(item, index) {
                                                        return {
                                                        "id": item.id,
                                                        "text": item.descripcion 
                                                        };
                                                    })
                                                    };
                                                }'),
                                        
                                            'cache' => true
                                        ],
                                    ],
                            ]);*/
                            ?>

                        <div class="form-group">
                            <?= Html::button('Agregar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onclick' => 'add_pac_prest(this);']) ?>
                       
                        </div>

                        <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>


