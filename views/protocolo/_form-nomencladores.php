<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Nomenclador;
use kartik\select2\Select2;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 10,
    'min' => 0,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => !empty($modelsNomenclador[0]) ? $modelsNomenclador[0] : new \app\models\InformeNomenclador(),
    'formId' => 'dynamic-form',
    'formFields' => [
        'servicio',
        'cantidad'
    ],
]); ?>  

<table class="table table-bordered no-margin">
    <thead>
        <tr>
            <th>Nomencladores</th>
            <th class="text-center">
                <button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-rooms">
    <?php foreach ($modelsNomenclador as $indexNom => $modelNomenclador): ?>
        <tr class="room-item">
            <td class="text-center vcenter" >
                <?php
                    // necessary for update action.
                    if (! $modelNomenclador->isNewRecord) {
                        echo Html::activeHiddenInput($modelNomenclador, "[{$indexEstudio}][{$indexNom}]id");
                    }
                ?>
                <div class="row">
                    <div class="col-md-7">
                        <?php $nomenclador = new Nomenclador; ?>
                        <?= $form->field($modelNomenclador, "[{$indexEstudio}][{$indexNom}]id_nomenclador",
                                        ['template' => "{label}
                                                <div class='col-md-8'>{input}</div>
                                                {hint}{error}",
                                                'labelOptions' => [ 'class' => 'col-md-4 control-label' ]])->dropDownList($nomenclador->getdropNomenclador(), [ 'prompt' => 'Nomenclador' ])->label('Servicio') ;?>
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($modelNomenclador, "[{$indexEstudio}][{$indexNom}]cantidad",
                                        ['template' => "{label}
                                                <div class='col-md-7'>{input}</div>
                                                {hint}{error}",
                                                'labelOptions' => [ 'class' => 'col-md-4 control-label' ]])->textInput(['maxlength' => true]) ?>
                    </div>
                 </div>
            </td>
            <td class="text-center vcenter" style="width: 50px;">
                <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>

