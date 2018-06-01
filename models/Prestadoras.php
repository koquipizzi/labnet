<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Prestadoras".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $telefono
 * @property string $domicilio
 * @property string $email
 * @property integer $Localidad_id
 * @property string $facturable
 * @property integer $Tipo_prestadora_id
 * @property integer $notas
 *
 * @property Nomenclador[] $nomencladors
 * @property PacientePrestadora[] $pacientePrestadoras
 * @property Localidad $localidad
 * @property TipoPrestadora $tipoPrestadora
 * @property Protocolo[] $protocolos
 * @property Tarifas[] $tarifas
 * @property integer $cobertura
 */
class Prestadoras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Prestadoras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Localidad_id','facturable'], 'required'],
            [['Localidad_id', 'Tipo_prestadora_id','id_old'], 'integer'],
            [['domicilio'], 'string', 'max' => 45],
            [['descripcion'], 'required'],
            [['notas'], 'string', 'max' => 512],
            [['email'],'email'],
            [['telefono'], 'string'],
            [['facturable'], 'string', 'max' => 1],
            [['Localidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['Localidad_id' => 'id']],
            [['Tipo_prestadora_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoPrestadora::className(), 'targetAttribute' => ['Tipo_prestadora_id' => 'id']],
            [['notas'], 'string', 'max' => 512],
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripcion' => Yii::t('app', 'Razón Social'),
            'telefono' => Yii::t('app', 'Teléfono'),
            'domicilio' => Yii::t('app', 'Domicilio'),
            'email' => Yii::t('app', 'Email'),
            'Localidad_id' => Yii::t('app', 'Localidad'),
            'facturable' => Yii::t('app', 'Facturable'),
            'Tipo_prestadora_id' => Yii::t('app', 'Tipo Prestadora'),
            'notas' => Yii::t('app', 'Notas'),
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomencladors()
    {
        return $this->hasMany(Nomenclador::className(), ['Prestadoras_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientePrestadoras()
    {
        return $this->hasMany(PacientePrestadora::className(), ['Prestadoras_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'Localidad_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidadnombre()
    {
        $localidad= $this->hasOne(Localidad::className(), ['id' => 'Localidad_id'])->one();
        //var_dump($localidad);die();
        return  $localidad;
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoPrestadora()
    {
        return $this->hasOne(TipoPrestadora::className(), ['id' => 'Tipo_prestadora_id']);
    }

     public static function getPaticular(){
         return  "3";
     }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProtocolos()
    {
        return $this->hasMany(Protocolo::className(), ['FacturarA_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifas()
    {
        return $this->hasMany(Tarifas::className(), ['Prestadoras_id' => 'id']);
    }
    
  
    
    public function getFacturableTexto()
    {       
         if($this->facturable=='S') return 'Si'; 
         else return 'No';
    }
    
    public function getTipoPrestadoraTexto()
    {       
        $tipo = $this->hasOne(TipoPrestadora::className(), ['id' => 'Tipo_prestadora_id'])->one();
        if ($tipo)
            {return $tipo->descripcion;}
        return '';
    }

 public function getLocalidadTexto()
    {
        $localidad = $this->hasOne(Localidad::className(), ['id' => 'Localidad_id'])->one();
        if($localidad)
        return $localidad->nombre;
        return "";

    }
    
}
