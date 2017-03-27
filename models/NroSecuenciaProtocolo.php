<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Nro_secuencia_protocolo".
 *
 * @property integer $id
 * @property string $fecha
 * @property integer $secuencia_diff
 * @property integer $secuencia
 */
class NroSecuenciaProtocolo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Nro_secuencia_protocolo';
    }

    
//    public function attributes() { return array_merge( parent::attributes() [$secuencia] ); }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha'], 'required'],
            [['fecha','secuencia_diff', 'secuencia'], 'safe'],
            [['secuencia_diff', 'secuencia'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'secuencia_diff' => Yii::t('app', 'Secuencia Diff'),
            'secuencia' => Yii::t('app', 'Secuencia'),
        ];
    }

    /**
     * @inheritdoc
     * @return NroSecuenciaProtocoloQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NroSecuenciaProtocoloQuery(get_called_class());
    }
}
