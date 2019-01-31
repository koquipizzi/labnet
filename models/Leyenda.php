<?php

namespace app\models;
use yii\db\Query;
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
            [['texto','codigo','categoria'], 'required'], 
            [['texto'], 'string', 'max' => 249],
            [['codigo'],'string', 'max' => 10],
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
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'A'])
    	->asArray()
    	->all();
    }
  
    public static function getTextoX(){
    	return Leyenda::find()
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'X'])
    	->asArray()
    	->all();
    }
    public static function getTextoC(){
    	return Leyenda::find()
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'C'])
    	->asArray()
    	->all();
    }
    public static function getTextoF(){
    	return Leyenda::find()
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'F'])
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
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'PAP',"codigo"=>"Material"])
    	->asArray()
    	->all();
    }

    public static function getMTecnicaPAP(){
    	return Leyenda::find()
    	  	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'PAP',"codigo"=>"Tecnica"])
    	->asArray()
    	->all();
    }
    
    public static function getMLeucositosPAP(){
    	return Leyenda::find()
    	->select(['texto','id as id','codigo'])->distinct()->where(['categoria'=>'1',"codigo"=>"LH"])
    	->asArray()
    	->all();
    }
    
    public static function existeCodigo($codigo,$categoriaId,$leyendaId){
        $existe=false;
        $query = new Query;
        $query	
            ->select(['Leyenda.id'])  
            ->from('Leyenda')                
            ->join(	
                'join', 
                'Leyenda_categoria',
                'Leyenda_categoria.id=Leyenda.categoria' 
            )  
            ->where([
                'Leyenda.codigo' => $codigo,
                'Leyenda.categoria'=> $categoriaId
            ]);
        $command = $query->createCommand();
        $data = $command->queryAll(); 
        if(!empty( $data) ){
            $existe = true;
        }


        if(!empty($leyendaId) && $leyendaId!=-1 ){       
            $query = new Query;    
            $query	
            ->select(['Leyenda.id'])  
            ->from('Leyenda')                
            ->join(	
                'join', 
                'Leyenda_categoria',
                'Leyenda_categoria.id=Leyenda.categoria' 
            )  
            ->where([
                'Leyenda.codigo' => $codigo,
                'Leyenda.categoria'=> $categoriaId,
                'Leyenda.id' => $leyendaId
            ]);
            $command = '';
            $command = $query->createCommand();
            $dataLeyenda = $command->queryAll(); 
        }
        //si existe quiere decir que es el nro_pedido del pedido, y puede volverse a usar para el mismo pedido
        if(!empty( $dataLeyenda) ){
            $existe = false;
        }
 


        return $existe;
    } 
    
    
}
