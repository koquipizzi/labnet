<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Procedencia".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $domicilio
 * @property integer $Localidad_id
 * @property string $telefono
 * @property string $mail
 * @property string $informacion_adicional
 *
 * @property Localidad $localidad
 * @property Protocolo[] $protocolos
 * @property Tarifas[] $tarifas
 */
class Procedencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Procedencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Localidad_id','descripcion'], 'required'],
            [['Localidad_id'], 'integer'],
            [['descripcion', 'domicilio', 'mail'], 'string', 'max' => 200],
            [['telefono'], 'string'],
            [['mail'], 'email'],
            [['informacion_adicional'], 'string', 'max' => 254],
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
            'descripcion' => Yii::t('app', 'Descripción'),
            'domicilio' => Yii::t('app', 'Domicilio'),
            'Localidad_id' => Yii::t('app', 'Localidad'),
            'telefono'=> Yii::t('app', 'Telefono'),
            'mail'=> Yii::t('app', 'Email'),
            'informacion_adicional'=> Yii::t('app', 'Observaciones'),
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
        return $this->hasMany(Protocolo::className(), ['Procedencia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifas()
    {
        return $this->hasMany(Tarifas::className(), ['Procedencia_id' => 'id']);
    }

    public function getLocalidadTexto()
    {
        $localidad = $this->hasOne(Localidad::className(), ['id' => 'Localidad_id'])->one();
        if ($localidad)
            return $localidad->nombre;
        return '';
    }
}
