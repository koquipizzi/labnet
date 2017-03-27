<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "Especialidad".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property MedicoEspecialidad[] $medicoEspecialidads
 */
class Especialidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Especialidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Especialidad'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicoEspecialidads()
    {
        return $this->hasMany(MedicoEspecialidad::className(), ['Especialidad_id' => 'id']);
    }
    
    
    
    public function getdropEspecialidad()
    {
    	$data =  Especialidad::find()->asArray()->all();
    	return ArrayHelper::map($data, 'id', 'nombre');
    }
}
