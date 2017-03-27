<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Medico_especialidad".
 *
 * @property integer $id
 * @property integer $Medico_id
 * @property integer $Especialidad_id
 *
 * @property Especialidad $especialidad
 * @property Medico $medico
 */
class Medico_especialidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Medico_especialidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Medico_id', 'Especialidad_id'], 'required'],
            [['Medico_id', 'Especialidad_id'], 'integer'],
            [['Especialidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['Especialidad_id' => 'id']],
            [['Medico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['Medico_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'Medico_id' => Yii::t('app', 'Medico ID'),
            'Especialidad_id' => Yii::t('app', 'Especialidad ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialidad()
    {
        return $this->hasOne(Especialidad::className(), ['id' => 'Especialidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedico()
    {
        return $this->hasOne(Medico::className(), ['id' => 'Medico_id']);
    }
}
