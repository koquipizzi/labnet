<?php 
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use amilna\elevatezoom\ElevateZoom;
?>


<h3>Imágenes del informe</h3>
 
    <div class="col-sm-12">

        <div class="fotorama"
             data-width="100%"
             data-ratio="800/600"
             data-minwidth="400"
             data-maxwidth="1000"
             data-minheight="600"
             data-maxheight="100%">
                 <?php
                 $images = [];
                 foreach ($dataproviderMultimedia->getModels() as $img)
                 {
                 //   echo Html::img('@web' . $img->webPath);
                    $images[]= Yii::$app->urlManager->baseUrl.$img->webPath;
                 }
                 ?>
        </div>
       
    </div>
    <div class="col-sm-6">
         <?php echo ElevateZoom::widget([
                            'images'=>$images,
                            'baseUrl'=>Yii::$app->urlManager->baseUrl.'/uploads',
                          //  'smallPrefix'=>'/.thumbs',
                            'mediumPrefix'=>'',
                        ]);
            ?>

    </div>


