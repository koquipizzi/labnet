<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Estado".
 *
 * @property integer $id
 * @property string $descripcion
 *
 * @property Workflow[] $workflows
 */
class Estado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Estado';
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
    public function getWorkflows()
    {
        return $this->hasMany(Workflow::className(), ['Estado_id' => 'id']);
    }
}
