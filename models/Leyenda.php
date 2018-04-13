<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%Leyenda}}".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $texto
 * @property string $categoria
 */
class Leyenda extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Leyenda}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo'], 'string'],
            [['texto','categoria'], 'string', 'max' => 50],
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
            'texto' => Yii::t('app', 'Texto'),
        ];
    }

    /**
     * @inheritdoc
     * @return LeyendaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LeyendaQuery(get_called_class());
    }
    
    public function getTexto(){
    	return $this->codigo .''.$this->texto;
    }
    
    public static function getTextoA(){
    	return Leyenda::find()
    	->select(['texto','id as id'])->distinct()->where(['categoria'=>'A'])
    	->asArray()
    	->all();
    }
  
    public static function getTextoX(){
    	return Leyenda::find()
    	->select(['texto','id as id'])->distinct()->where(['categoria'=>'X'])
    	->asArray()
    	->all();
    }
    public static function getTextoC(){
    	return Leyenda::find()
    	->select(['texto','id as id'])->distinct()->where(['categoria'=>'C'])
    	->asArray()
    	->all();
    }
    public static function getTextoF(){
    	return Leyenda::find()
    	->select(['texto','id as id'])->distinct()->where(['categoria'=>'F'])
    	->asArray()
    	->all();
    }
    public static function getTextoO(){
    	return Leyenda::find()
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'O'])
    	->asArray()
    	->all();
    }
    public static function getTextoM(){
    	return Leyenda::find()
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'M'])
    	->asArray()
    	->all();
    }
    
     public static function getMaterialPAP(){
    	return Leyenda::find()
    	->select(['texto','id as id'])->distinct()->where(['categoria'=>'PAP',"codigo"=>"Material"])
    	->asArray()
    	->all();
    }

    public static function getMTecnicaPAP(){
    	return Leyenda::find()
    	  	->select(['texto','id as id'])->distinct()->where(['categoria'=>'PAP',"codigo"=>"Tecnica"])
    	->asArray()
    	->all();
    }
    
    public static function getMLeucositosPAP(){
    	return Leyenda::find()
    	->select(['texto','id as id'])->distinct()->where(['categoria'=>'1',"codigo"=>"LH"])
    	->asArray()
    	->all();
    }
    
//     public function getCodigoTexto(){
//     	$query= new Query();
//     	$query->select()->from('leyenda')->where(['like', 'name', ['test', 'sample']]);
//     	$this->find('codigo')->where(['like %codigo'],['like %texto'])->one();
//     	return;
//     }
    
    
    
}
