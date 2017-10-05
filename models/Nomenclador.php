<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Nomenclador".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $valor
 * @property integer $Prestadoras_id
 * @property string $servicio
 * @property string $coseguro
 *
 * @property Prestadoras $prestadoras
 * @property Tarifas[] $tarifas
 */
class Nomenclador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Nomenclador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor', 'coseguro','servicio'], 'number'],
            [['valor', 'coseguro','servicio'], 'required'],
            [['Prestadoras_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 45],
           // [['servicio'], 'string', 'max' => 30],
            [['Prestadoras_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadoras::className(), 'targetAttribute' => ['Prestadoras_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripcion' => Yii::t('app', 'Nombre'),
            'valor' => Yii::t('app', 'Valor'),
            'Prestadoras_id' => Yii::t('app', 'Prestadora'),
            'servicio' => Yii::t('app', 'Código'),
            'coseguro' => Yii::t('app', 'Coseguro'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestadoras()
    {
        return $this->hasOne(Prestadoras::className(), ['id' => 'Prestadoras_id']);
    }

    public function getPrestadoraTexto()
    {       
        $prestadora = $this->hasOne(Prestadoras::className(), ['id' => 'Prestadoras_id'])->one();
        if ($prestadora)
            return $prestadora->descripcion;
        return '';
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifas()
    {
        return $this->hasMany(Tarifas::className(), ['Nomenclador_id' => 'id']);
    }

    public function getdropNomenclador()
    {
        $data =  Nomenclador::find()->asArray()->all();
        return ArrayHelper::map($data, 'id', 'servicio');
    }


}
