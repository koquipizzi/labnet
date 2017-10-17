<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Laboratorio".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $admin
 * @property string $path_logo
 * @property string $direccion
 * @property string $web
 * @property string $telefono
 * @property string $mail
 * @property string $info_mail
 * @property string $path_firma
 */
class Laboratorio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $path_logos;
    public $path_firma;
    public $files;
    public static function tableName()
    {
        return 'Laboratorio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 1024],
            [['descripcion', 'admin', 'path_logo','path_firma', 'direccion', 'web', 'telefono', 'mail', 'info_mail'], 'string', 'max' => 255],
            [['path_logos','path_firma'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'admin' => Yii::t('app', 'Admin'),
            'path_logo' => Yii::t('app', 'Path Logo'),
            'direccion' => Yii::t('app', 'Direccion'),
            'web' => Yii::t('app', 'Web'),
            'telefono' => Yii::t('app', 'Telefono'),
            'mail' => Yii::t('app', 'Mail'),
            'info_mail' => Yii::t('app', 'Info Mail'),
        ];
    }
    
     /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'path_logos');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // the uploaded image instance
        return $image;
    }
   public function getImageFilePath()
    {
    	if( substr(Yii::$app->params['uploadPathLogo'],-1) == DIRECTORY_SEPARATOR ){
    		return Yii::$app->params['uploadPathLogo'];
    	}
    	return Yii::$app->params['uploadPathLogo'] . DIRECTORY_SEPARATOR;
    }
    
    public function getUrlImageFolder()
    {
    	return Yii::$app->params['urlImageFolderLogo'];
    }
    
       public function getImageFilePathFirma()
    {
    	if( substr(Yii::$app->params['uploadPathFirmaDigital'],-1) == DIRECTORY_SEPARATOR ){
    		return Yii::$app->params['uploadPathFirmaDigital'];
    	}
    	return Yii::$app->params['uploadPathFirmaDigital'] . DIRECTORY_SEPARATOR;
    }
    
    public function getUrlImageFolderFirma()
    {
    	return Yii::$app->params['urlImageFolderFirmaDigital'];
    }
    
}
