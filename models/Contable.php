<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Contable".
 *
 * @property integer $id
 * @property string $paciente
 */
class Contable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Contable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paciente'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'paciente' => Yii::t('app', 'Paciente'),
        ];
    }
}
