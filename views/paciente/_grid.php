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
                            $data =  Prestadoras::find()->asArray()->all();
                            $data2 =  ArrayHelper::map($data, 'id', 'descripcion');

                             $data = Prestadoras::find()->all();
                            $data2 = ArrayHelper::map($data,'id', 'descripcion');
                           
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
                                    'nro_afiliado',
                                    ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete} {crear}',
                                    'buttons' => [
                                    //view button
                                    
                                    
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
                                                    'class'=>'btn bg-purple btn-flat custom_button btn-xs', 
                                                    'onclick'=> 'SimpleLoading.start();', 
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
    'Agregar Prestadora',
    [
        'class' => 'btn btn-primary boton_addP',
        'onclick' => '$(".addP").show(); $(".boton_addP").hide();',
    ]
);
?>
        <div class="box box-primary addP" style="display:none; margin-top: 10px;">
            <div class="box-header">
                Nueva Prestadora
            </div>
            <div class="box-body">
                
                <div class="paciente-prestadora-form">

                        <?php $form = ActiveForm::begin(['action' => Url::to('/index.php?r=paciente-prestadora/create'),
                                                                    'id' => 'pac_prest']); ?>

                        <?= $form->field($model, 'nro_afiliado')->textInput(['maxlength' => true]) ?>

                        <?php echo $form->field($model, 'Paciente_id')->hiddenInput( array('value'=>$paciente_id))->label(false);?>

                        <?php //$form->field($model, 'Prestadoras_id')->textInput() ?>

                        <?php echo $form->field($model, 'Prestadoras_id',[
                               'template' => "{label}
                                            <div id='SelecNomenclador'>{input}</div>
                                            {hint}
                                            {error}"
                                            ]
                                            )->widget(Select2::classname(), [
                                    'data'=>$data2,'language'=>'es',
                                    'toggleAllSettings' => [                                    
                                    'selectOptions' => ['class' => 'text-success'],
                                    'unselectOptions' => ['class' => 'text-danger'],
                                     ],
                                    'options' => ['multiple' => false]
                            ]);
                        ?>

                        <div class="form-group">
                            <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onclick' => 'add_pac_prest(this);']) ?>
                       
                        </div>

                        <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>

 <?php
     Modal::begin([
        'header' =>'<h4>Ficha</h4>',
        'id'     =>'modalKoki',
        'size'   =>'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
        ]);
    echo "<div id='modalContent'> </div>";
    Modal::end();


 ?>
