<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use kartik\datecontrol\DateControl;
    use yii\widgets\Pjax;
    use yii\helpers\Url;
    use app\models\Estudio;
    
    $this->title = Yii::t('app', 'Buscador');
?>
<?php
    $javaScript = <<<JS
    
    $('#entidad-select').on('change',function() {
        if ($('#entidad-select').val() === '3' ){
            $('.protocolo-search').show();
        }else{
             $('.protocolo-search').hide();
        }
    });

    $('#search-filtro').on('click',function() {
        var palabra =  $('#search-field').val();
        var entidad =  $('#entidad-select').val();
        var fecha =  $('#date-selected').val();
        var tipoInforme =  $('#informe-filter').val();
        var data = {
            palabra : palabra,
            entidad : entidad,
            fecha  : fecha,
            tipoInforme : tipoInforme
        }
        $.post( ajaxurl , data ,function( data ) {
                if (data.result == 'ok'){
                    $('#result').html(data.info);
                }
        });
    })
JS;
    $this->registerJs('var ajaxurl = "' .Url::to(['site/filtrar-busqueda']). '";', \yii\web\View::POS_HEAD);
    $this->registerJs($javaScript);
?>

<div class="box box-info box-header search_strong" style="padding-top: 0px" >
    <div class="col-xs-3 form-group">
        <div class="box-footer">
            <div class="input-group">
                    <input id="search-field" type="text" name="q" class="form-control" placeholder="Buscar..."/>
                    <span class="input-group-btn">
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="box-footer">
            <select id="entidad-select" class="form-control" data-live-search="true">
                    <option value="1">Todos</option>
                    <option value="2">Pacientes</option>
                    <option value="3">Protocolos</option>
                    <option value="4">Medicos</option>
            </select>
        </div>
    </div>
    <div class="col-xs-3 protocolo-search" style="display: none; ">
        <div class="box-footer">
            <?php
                echo DateControl::widget([
                    'name'=>'kartik-date',
                   // 'value'=>time(),
                    'id' => 'date-selected',
                    'type'=>DateControl::FORMAT_DATE,
                    'displayFormat' => 'php:d/m/Y',
                    'saveFormat' => 'php:U',
                ]);
            ?>
        </div>
    </div>
    <div class="col-xs-3 protocolo-search" style="display: none; ">
        <div class="box-footer">
            <select id="informe-filter" class="form-group form-control" data-live-search="true">
                <?php
                $estudios = Estudio::find()->all();
                foreach ($estudios as $estudio){
                    $id = $estudio->id;
                ?>
                    
                    <option value="<?php echo $id;?>"><?php echo $estudio->nombre ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="box-footer pull-right">
        <button id="search-filtro" class="btn btn-primary">Buscar</button>
    </div>
</div>
<div id="result">
    
    <?php
        if (!empty($html)){
            echo $html;
        }
    ?>

</div>


