<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medico */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Medicos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => 
                        [
                            'nombre',
                            'email:email',
                            [
                            'label'=>'Especialidad',
                            'value'=>$model->getEspecialidadTexto(),
                            ],
                            'domicilio',
                            'telefono',
                             [
                            'label'=>'Localidad',
                            'value'=>$model->getLocalidadTexto(),
                            ],
                             ],
                     ]) 
        ?>

    <!--div class="form-footer">
        <div style="text-align: right;">
        <button type="button" class="btn btn-teal" data-dismiss="modal">Cerrar</button>
        </div>         
    </div-->
