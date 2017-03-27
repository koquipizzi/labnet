<?php
namespace app\models;
use Yii;
/**
 * This is the model class for table "Localidad".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $cp
 * @property integer $caracteristica_telefonica
 *
 * @property Medico[] $medicos
 * @property Paciente[] $pacientes
 * @property Prestadoras[] $prestadoras
 * @property Procedencia[] $procedencias
 */
class Localidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Localidad';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 100],
            [['cp'], 'string', 'max' => 10],
            [['caracteristica_telefonica'],'integer'],
            [['nombre', 'cp'], 'required'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'cp' => 'Código Postal',
            'caracteristica_telefonica' => 'Característica Telefonica'
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasMany(Medico::className(), ['Localidad_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['Localidad_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestadoras()
    {
        return $this->hasMany(Prestadoras::className(), ['Localidad_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedencias()
    {
        return $this->hasMany(Procedencia::className(), ['Localidad_id' => 'id']);
    }
}