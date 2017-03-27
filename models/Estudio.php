<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Estudio".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $nombre
 * @property string $titulo
 * @property string $columnas
 * @property string $template
 *
 * @property Informe[] $informes
 */
class Estudio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Estudio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'columnas'], 'string', 'max' => 255],
            [['nombre', 'titulo'], 'string', 'max' => 45],
            [['template'], 'string', 'max' => 4096],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'nombre' => Yii::t('app', 'Nombre'),
            'titulo' => Yii::t('app', 'Titulo'),
            'columnas' => Yii::t('app', 'Columnas'),
            'template' => Yii::t('app', 'Template'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformes()
    {
        return $this->hasMany(Informe::className(), ['Estudio_id' => 'id']);
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombreCorto()
    {
         
        return substr($this->nombre, 0,4);
    }
    

    public static function getEstudioPap()
    {
    	return 1;
    }

    public static function getEstudioBiopsia()
    {
    	return 2;
    }
    
    public static function getEstudioMolecular()
    {
    	return 3;
    }
    
    public static function getEstudioCitologia()
    {
    	return 4;
    }
    
    public static function getEstudioInmuno()
    {
    	return 5;
    }
    
}
