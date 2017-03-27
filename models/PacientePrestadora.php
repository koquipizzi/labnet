<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Paciente_prestadora".
 *
 * @property integer $id
 * @property string $nro_afiliado
 * @property integer $Paciente_id
 * @property integer $Prestadoras_id
 *
 * @property Paciente $paciente
 * @property Prestadoras $prestadoras
 * @property Protocolo[] $protocolos
 */
class PacientePrestadora extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Paciente_prestadora';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Paciente_id', 'Prestadoras_id'], 'required'],
            [['Paciente_id', 'Prestadoras_id'], 'integer'],
            [['nro_afiliado'], 'string', 'max' => 45],
            [['Paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['Paciente_id' => 'id']],
            [['Prestadoras_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadoras::className(), 'targetAttribute' => ['Prestadoras_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nro_afiliado' => Yii::t('app', 'Nro Afiliado'),
            'Paciente_id' => Yii::t('app', 'Paciente ID'),
            'Prestadoras_id' => Yii::t('app', 'Prestadoras ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'Paciente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestadoras()
    {
        return $this->hasOne(Prestadoras::className(), ['id' => 'Prestadoras_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProtocolos()
    {
        return $this->hasMany(Protocolo::className(), ['Paciente_prestadora_id' => 'id']);
    }
    
    public function getPrestadoraTexto()
    {   
        $prestadora = $this->hasOne(Prestadoras::className(), ['id' => 'Prestadoras_id'])->one();
        if ($prestadora)
            return $prestadora->descripcion;
        return '';
    }
}
