<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "Medico".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $email
 * @property string $especialidad
 * @property string $domicilio
 * @property string $telefono
 * @property integer $Localidad_id
 *
 * @property Localidad $localidad
 * @property Protocolo[] $protocolos
 */
class Medico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Medico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Localidad_id','nombre'], 'required'],
            [['Localidad_id', 'especialidad_id'], 'integer'],
            [['nombre'], 'string', 'max' => 33],
            [['email'], 'email'],
            [['telefono'], 'string'], 
            [['domicilio'], 'string', 'max' => 45],     
            [['notas'], 'string', 'max' => 512],
            [['Localidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['Localidad_id' => 'id']],
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
            'email' => Yii::t('app', 'Email'),
            'especialidad_id' => Yii::t('app', 'Especialidad'),
            'domicilio' => Yii::t('app', 'Domicilio'),
            'telefono' => Yii::t('app', 'Teléfono'),
            'Localidad_id' => Yii::t('app', 'Localidad'),
            'notas' => Yii::t('app', 'Notas'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'Localidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProtocolos()
    {
        return $this->hasMany(Protocolo::className(), ['Medico_id' => 'id']);
    }
    
    public function getLocalidadTexto()
    {       
        $localidad = $this->hasOne(Localidad::className(), ['id' => 'Localidad_id'])->one();
        if ($localidad)
            return $localidad->nombre;
        return '';
    }
    
    
    public function getEspecialidadTexto()
    {
        $esp = $this->hasOne(Especialidad::className(), ['id' => 'especialidad_id'])->one();
        if (isset($esp) && $esp!="" )
            return $esp->nombre;
        return 'No tiene';
    }
    
    
    
    
    
}
