<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Prestadoras */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prestadoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="">

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Cipat <span>Prestadora "<?= Html::encode($this->title) ?>"</span>
         <a href="#" style="position:relative; float:right;" data-dismiss="modal"><i class="fa fa-close"></i></a>
        </h2>        
    </div><!-- /.header-content -->
   
  
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="prestadoras-view">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?= Html::encode($this->title) ?>

                        <p style="float: right;">
                        <?=                             Html::a('<span class="fa fa-pencil"></span>', 'index.php?r=prestadoras/update&id='.$model->id, [
                            'title' => Yii::t('app', ' Editar '),
                            'class'=>'btn btn-info btn-xs',                                  
                ]); ?>
                        <?=                             Html::a('<span class="fa fa-trash "></span>', 'index.php?r=prestadoras/delete&id='.$model->id, [
                            'class' => 'btn btn-danger btn-xs',
                            'title' => Yii::t('app', ' Eliminar '),
                            'data' => [
                                'confirm' => Yii::t('app', 'Está seguro que quiere eliminar este item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    </h3>
                </div>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'descripcion',
                        'telefono',
                        'domicilio',
                        'email:email',
                        [
                            'attribute'=>'Localidad',
                            'value'=> $model->getLocalidadTexto(),
                        ],
                        [
                            'attribute'=>'Facturable',
                            'value'=> $model->getFacturableTexto(),
                        ], 
                        [
                            'attribute'=>'Tipo Prestadora',
                            'value'=> $model->getTipoPrestadoraTexto(),
                        ],                        
                    ],
                ]) ?>

            </div>
        </div>
  </div>
</section>

