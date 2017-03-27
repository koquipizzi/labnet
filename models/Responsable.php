<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Responsable".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Workflow[] $workflows
 */
class Responsable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Responsable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflows()
    {
        return $this->hasMany(Workflow::className(), ['Responsable_id' => 'id']);
    }
}
