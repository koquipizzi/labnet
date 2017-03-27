<?php 
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>


<h3>Imágenes del informe</h3>
    <div class="col-sm-12">
                 <?php

           
                 $images = [];
                 foreach ($dataproviderMultimedia->getModels() as $img)
                 {  
                     ?>
                  <div style="width: 151px; left: 0px; top: 0px;" class="cbp-item">
				<div class="cbp-item-wrapper">
                            <!--<a class="cbp-caption cbp-lightbox" data-title="Glamour female<br>by John Kribo" href="http://img.djavaui.com/?create=1200x900,e5599d?f=ffffff">-->
                                 <?php
                      echo Html::a(Html::img(Yii::$app->urlManager->baseUrl.$img->webPath, ['width'=>'150']), Yii::$app->urlManager->baseUrl.$img->webPath, ['rel' => 'fancybox', 'data-fancybox' => 'gallery', 'class' => 'cbp-caption-defaultWrap']); 
                      ?>    
                            <!--</a>-->
                        	</div>
			</div>
                  <?php     
                 }
                 ?>
        </div>



