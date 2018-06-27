<?php
use yii\helpers\Html;
use yii\helpers\Url;
use xj\bootbox\BootboxAsset;
/* @var $this yii\web\View */
/* @var $model app\models\Protocolo */
$codigo = $model->codigo;
if (empty($codigo)){
    $codigo = '';
}
$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => 'Protocolo']) . $codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Protocolos'), 'url' => ['all']];
$this->params['breadcrumbs'][] = ['label' => $codigo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$url = Url::to(['protocolo/delete',"id"=>$model->id]);  
$urlIndex =Url::to(['protocolo/index']) ;
BootboxAsset::register($this);
$js2= " 
$('#btn_delete').click(function()
{
    var pedido_id=$(this).val();
    bootbox.dialog
    ({ 
    
        message: '¿Confirma que desea eliminar el protocolo?',
        title: 'Sistema LabNet',
        // className: 'modal-info modal-center',
        buttons: 
        {
            success: 
            {
                label: 'Aceptar',
                className: 'btn-primary',
                callback: function () 
                {
                    $.ajax(                    
                        {
                            url:'{$url}',
                            data: {id:pedido_id,},
                            type: 'POST',                                                  
                            success: function (response) 
                            {
                                if(response.rta=='ok')
                                {
                                $(location).attr('href','{$urlIndex}');
                                }     
                                if(response.rta=='error')
                                {  
                                    var n = noty
                                    ({
                                        text:response.msj,
                                        type: 'error',
                                        class: 'animated pulse',
                                        layout: 'topCenter',
                                        theme: 'relax',
                                        timeout: 8000, // delay for closing event. Set false for sticky notifications
                                        force: false, // adds notification to the beginning of queue when set to true
                                        modal: false, // si pongo true me hace el efecto de pantalla gris
                                        // maxVisible : 10
                                    });
                                }                            
                            },
                            error: function (response) 
                            {
                                bootbox.alert('Error');
                            }
                            
                        
                        })
                }
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-danger',
                }
        }
    });

}); ";

$this->registerJs($js2);
?>

<section id="page-content">
    <div class="header-content">     
    </div><!-- /.header-content -->
    
    <!-- Start body content -->
    <div class="body-content animated fadeIn" >
        <div class="panel rounded shadow">
            <div class="protocolo-update">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                    </div>
                    <div class="pull-right">
                        <?php
                            echo "<button data-toggle='tooltip' title='' id='btn_delete' class='btn btn-primary' value='{$model->id}' >".Yii::t('app', 'Delete')."</button>";
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->                 
                <?= $this->render('_form_update', [
                            'model' => $model,
                            'searchModel' =>$searchModel ,
                            'dataProvider' => $dataProvider,
                            'modelsInformes'=>$modelsInformes,
                            'nomenclador'=>$nomenclador,
                            'PacientePrestadora'=>$PacientePrestadora                            
                ]) ?>

            </div>
        </div>
    </div>
</section>
            
