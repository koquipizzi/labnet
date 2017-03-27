<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Pago".
 *
 * @property integer $id
 * @property string $fecha
 * @property double $importe
 * @property integer $nro_formulario
 * @property string $observaciones
 * @property integer $Prestadoras_id
 *
 * @property Informe[] $informes
 * @property Prestadoras $prestadoras
 */
class Pago extends \yii\db\ActiveRecord
{
    public $fecha_desde;
    public $fecha_hasta;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Pago';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'importe', 'Prestadoras_id','nro_formulario'], 'required'],
            [['fecha'], 'safe'],
            [['importe'], 'double'],
            [[ 'nro_formulario', 'Prestadoras_id'], 'integer'],
            [['observaciones'], 'string'],
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
            'fecha' => Yii::t('app', 'Fecha'),
            'importe' => Yii::t('app', 'Importe'),
            'nro_formulario' => Yii::t('app', 'Nro.Formulario'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'Prestadoras_id' => Yii::t('app', 'Prestadora'),
            'fecha_desde' => Yii::t('app', 'F.Desde'),
            'fecha_hasta' => Yii::t('app', 'F.Hasta'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformes()
    {
        return $this->hasMany(Informe::className(), ['Pago_id' => 'id']);
    }

  
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestadoras()
    {
        return $this->hasOne(Prestadoras::className(), ['id' => 'Prestadoras_id']);
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getFechaseteada()
    {
        $fecha= $this->fecha;
        $arr = explode('-',$fecha);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }
    
            /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacionesseteada()
    {
        $obs= $this->observaciones;
        if(isset($obs) && $obs!="" ){
          return $obs;   
        }else{
            return "No Contiene.";   
        }
       
    }
    
  public function getImporteSeteado()
    {
        $i= $this->importe;
      return "$ ".$i;
       
    }
    
        
  public function getPrestadoraName()
    {
       $p=  $this->hasOne(Prestadoras::className(), ['id' => 'Prestadoras_id'])->one();
         return $p["descripcion"];
       
    }


    
    
    
}
