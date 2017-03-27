<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PrestadoraTemp".
 *
 * @property integer $id
 * @property string $nro_afiliado
 * @property integer $Prestadora_id
 * @property string $tanda
 */
class PrestadoraTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PrestadoraTemp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            [['Prestadora_id'], 'integer'],
            [['nro_afiliado', 'tanda'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nro_afiliado' => Yii::t('app', 'Nro Afiliado'),
            'Prestadora_id' => Yii::t('app', 'Prestadora'),
            'tanda' => Yii::t('app', 'Tanda'),
        ];
    }
    
    public function getPrestadoraTexto()
    {       
        $prestadora = $this->hasOne(Prestadoras::className(), ['id' => 'Prestadora_id'])->one();
        if ($prestadora)
            return $prestadora->descripcion;
        return '';
    }
}
