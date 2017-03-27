<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Textos".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $material
 * @property string $tecnica
 * @property string $macro
 * @property string $micro
 * @property string $diagnos
 * @property string $observ
 * @property integer $estudio_id
 */
class Textos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Textos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material', 'tecnica', 'macro', 'micro', 'diagnos', 'observ'], 'string'],
            [['estudio_id'], 'integer'],
            [['codigo'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Código'),
            'material' => Yii::t('app', 'Material'),
            'tecnica' => Yii::t('app', 'Técnica'),
            'macro' => Yii::t('app', 'Macro'),
            'micro' => Yii::t('app', 'Micro'),
            'diagnos' => Yii::t('app', 'Diagnóstico'),
            'observ' => Yii::t('app', 'Observaciones'),
            'estudio_id' => Yii::t('app', 'Estudio'),
        ];
    }
}
