<?php

namespace app\controllers;

use Yii;
use app\models\Laboratorio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * LaboratorioController implements the CRUD actions for Laboratorio model.
 */
class LaboratorioController extends Controller
{
    /**
     * @inheritdoc
     */
    //   public $layout = 'lay-admin-footer-fixed';
    public $path_logos = [];
    
    public function behaviors ()
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
     * Lists all Laboratorio models.
     * @return mixed
     */
    public function actionIndex ()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Laboratorio::find(),
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Laboratorio model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView ($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new Laboratorio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate ()
    {
        $model = new Laboratorio();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing Laboratorio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate ($id){
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }
    
    public function actionLogo($id=null){
      
        $model = \app\models\Laboratorio::find('id')->one();
 
        $carpeta = Yii::getAlias('@webroot').'/uploads/logo';
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0755, true);
        }
    
        if(!isset($model)){
            $model= new \app\models\Laboratorio();
            $model->save();
        }
        
        // Load images
        $img = UploadedFile::getInstances($model,'files');
        $image = $img[0];
      
        $model->path_logo = $image->name;
        $pathName = $model->getImageFilePath();
        $pathFolder = $model->getUrlImageFolder();
        
        $nameOfFile=explode(".", $image->name);
        $ext = end($nameOfFile);
        $filename = "Logo.{$ext}";
        $model->path_logo = $model->getImageFilePath(). $filename;
        $model->web_path = $model->getUrlImageFolder(). $filename;
        if ($image->saveAs($model->path_logo, true)){
                $model->save();
        }
        return true;
    }
    
    public function actionFirmadigital($id=null)
    {
        $model = \app\models\Laboratorio::find('id')->one();
        
        $carpeta = Yii::getAlias('@webroot').'/uploads/firma';
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0755, true);
        }
        
        if(!isset($model)){
            $model= new \app\models\Laboratorio();
            $model->save();
        }
        // Load images
        $img = UploadedFile::getInstances($model,'files');
        $image = $img[0];
      
        $model->path_firma = $image->name;
        $pathName = $model->getImageFilePathFirma();
        $pathFolder = $model->getUrlImageFolderFirma();
        

        $nameOfFile = explode(".", $image->name);
        $ext = end($nameOfFile);
        $filename = "Firma_Digital.{$ext}";
        $model->path_firma = $model->getImageFilePathFirma() . $filename;
        $model->web_path_firma = $model->getUrlImageFolderFirma(). $filename;
        if ($image->saveAs($model->path_firma, true)){
                $model->save();
        }
        return true;
    }
    
    /**
     * Deletes an existing Laboratorio model.
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
     * Finds the Laboratorio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Laboratorio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Laboratorio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
