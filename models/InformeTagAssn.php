<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "informe_tag_assn".
 *
 * @property integer $informe_id
 * @property integer $tag_id
 */
class InformeTagAssn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'informe_tag_assn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['informe_id', 'tag_id'], 'required'],
            [['informe_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'informe_id' => Yii::t('app', 'Informe ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }
}
