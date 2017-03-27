<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "InformeNomencladorTemporal".
 *
 * @property integer $id
 * @property integer $id_informeTemp
 * @property integer $id_nomenclador
 *
 * @property InformeTemp $idInformeTemp
 * @property Nomenclador $idNomenclador
 */
class InformeNomencladorTemporal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InformeNomencladorTemporal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_informeTemp', 'id_nomenclador'], 'required'],
            [['id_informeTemp', 'id_nomenclador'], 'integer'],
            [['id_informeTemp'], 'exist', 'skipOnError' => true, 'targetClass' => InformeTemp::className(), 'targetAttribute' => ['id_informeTemp' => 'id']],
            [['id_nomenclador'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclador::className(), 'targetAttribute' => ['id_nomenclador' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_informeTemp' => Yii::t('app', 'Id Informe Temp'),
            'id_nomenclador' => Yii::t('app', 'Id Nomenclador'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInformeTemp()
    {
        return $this->hasOne(InformeTemp::className(), ['id' => 'id_informeTemp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNomenclador()
    {
        return $this->hasOne(Nomenclador::className(), ['id' => 'id_nomenclador']);
    }

    /**
     * @inheritdoc
     * @return InformeNomencladorTemporalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InformeNomencladorTemporalQuery(get_called_class());
    }
}
