<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

use yii\helpers\BaseFileHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
  //  public $layout = 'lay-admin-footer-fixed';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->status=1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id=null)
    {
        $file=Yii::$app->request->post('id');
            if(isset($file)){
                $this->multimediaUpload();
                $id=$model->id;
         // return "lala";
               return true;
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
      
    public static function findByUsername($username){
        return self::findOne(['username'=>$username]);
    }

    public function multimediaUpload(){
        $model = $this->findModel( $_POST['id']);
        $width = 80;
	    $height = 80;
        $cropInfo =["x"=> "12","width"=>"100","y"=>"0","height"=> "100"];
                
                
        $imageFile = UploadedFile::getInstances($model, 'files');
     //    var_dump($imageFile); die();
        $directory = Yii::getAlias('@app/web/images/users'). DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
       
        if (!file_exists($directory)) {
		    BaseFileHelper::createDirectory( $directory, $mode = 0755, $recursive = true );
		}

      //  if ($imageFile) {
        foreach ($imageFile as $file) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $file->extension;
            $filePath = $directory . $fileName;

            $image = Image::crop($file,
                    intval($cropInfo['width']),
                    intval($cropInfo['height']),
					[$cropInfo['x'], $cropInfo['y']])->resize(new Box($width, $height));

            if ($image->saveAs($filePath, true)) {
                $path = '/images/users' . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                $model->avatar = $path;
                $model->save();
            }
        }

        return;

        }


    public function actionImageDelete($name)
    {
        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }

        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $fileName = basename($file);
            $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }
        return Json::encode($output);
    }
}
