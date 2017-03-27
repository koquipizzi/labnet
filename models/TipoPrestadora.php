<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tipo_prestadora".
 *
 * @property integer $id
 * @property string $descripcion
 *
 * @property Prestadoras[] $prestadoras
 */
class TipoPrestadora extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tipo_prestadora';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestadoras()
    {
        return $this->hasMany(Prestadoras::className(), ['Tipo_prestadora_id' => 'id']);
    }
}
