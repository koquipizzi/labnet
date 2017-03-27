<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tarifas".
 *
 * @property integer $id
 * @property string $valor
 * @property string $coseguro
 * @property integer $Procedencia_id
 * @property integer $Prestadoras_id
 * @property integer $Nomenclador_id
 *
 * @property Nomenclador $nomenclador
 * @property Prestadoras $prestadoras
 * @property Procedencia $procedencia
 */
class Tarifas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tarifas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor', 'coseguro'], 'number'],
            [['Procedencia_id', 'Prestadoras_id', 'Nomenclador_id'], 'required'],
            [['Procedencia_id', 'Prestadoras_id', 'Nomenclador_id'], 'integer'],
            [['Nomenclador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclador::className(), 'targetAttribute' => ['Nomenclador_id' => 'id']],
            [['Prestadoras_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadoras::className(), 'targetAttribute' => ['Prestadoras_id' => 'id']],
            [['Procedencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Procedencia::className(), 'targetAttribute' => ['Procedencia_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'valor' => Yii::t('app', 'Valor'),
            'coseguro' => Yii::t('app', 'Coseguro'),
            'Procedencia_id' => Yii::t('app', 'Procedencia ID'),
            'Prestadoras_id' => Yii::t('app', 'Prestadoras ID'),
            'Nomenclador_id' => Yii::t('app', 'Nomenclador ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomenclador()
    {
        return $this->hasOne(Nomenclador::className(), ['id' => 'Nomenclador_id']);
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
    public function getProcedencia()
    {
        return $this->hasOne(Procedencia::className(), ['id' => 'Procedencia_id']);
    }
}
