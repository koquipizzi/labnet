<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'frequency' => Yii::t('app', 'Frequency'),
        ];
    }

    public static function findAllByName($query)
    {
       // return Tag::find()->where('name LIKE :query')
      //  ->addParams([':query'=>"%$name%"])
      //  ->all();
      return Tag::find()
      ->where(['like', 'name', $query])->limit(50)->all();

    }

    public function getInformes() // is a RELATIONSHIP to the model you wish to attach your tags
    {
        return $this->hasMany(Informe::className(), ['id' => 'informe_id'])->viaTable('informe_tag_assn', ['tag_id' => 'id']);
    }
}
