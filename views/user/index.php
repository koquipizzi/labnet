<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Usuarios');
$this->params['breadcrumbs'][] = $this->title;
?>
     <div class="header-content">
                <div class="pull-left">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="pull-right">
                    <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="clearfix"></div>


    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>array('class'=>'table table-striped table-lilac'),
        'filterModel' => $searchModel,
        'columns' => [
            'username',
            'email:email',
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {edit} {delete}',
            'buttons' => [

            //view button
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-eye "></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-success btn-xs',
                ]);
            },
             'edit' => function ($url, $model) {
                return Html::a('<span class="fa fa-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Editar'),
                            'class'=>'btn btn-info btn-xs',
                ]);
            },
             'delete' => function ($url, $model) {
                return Html::a('<span class="fa fa-trash"></span>', $url, [
                            'title' => Yii::t('app', 'Borrar'),
                            'class'=>'btn btn-danger btn-xs',
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=user/view&id='.$model->id;
                return $url;
                }
            if ($action === 'edit') {
                $url ='index.php?r=user/update&id='.$model->id;
                return $url;
                }
            if ($action === 'delete') {
                $url ='index.php?r=user/delete&id='.$model->id;
                return $url;
                }
            }
        ],
         ],
    ]); ?>
<?php Pjax::end(); ?></div>
    </div>

<style>
    .summary{
        float:left;
    }

</style>
