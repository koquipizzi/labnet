<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%Leyenda_categoria}}".
 *
 * @property integer $id
 * @property string $descripcion
 */
class LeyendaCategoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Leyenda_categoria}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'string'],
            [['descripcion'], 'string', 'max' => 50],
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
        ];
    }

    
    
}
