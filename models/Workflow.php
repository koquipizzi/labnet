<?php

namespace app\models;
use yii\db\Query;
use Yii;

/**
 * This is the model class for table "Workflow".
 *
 * @property integer $id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $Estado_id
 * @property integer $Responsable_id
 * @property integer $Informe_id
 *
 * @property User $responsable
 * @property Estado $estado
 * @property Informe $informe
 */
class Workflow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Workflow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Estado_id', 'Responsable_id', 'Informe_id'], 'integer'],
            [['Informe_id'], 'required'],
            [['fecha_inicio', 'fecha_fin'], 'string', 'max' => 22],
            [['Responsable_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['Responsable_id' => 'id']],
            [['Estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['Estado_id' => 'id']],
            [['Informe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Informe::className(), 'targetAttribute' => ['Informe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
            'fecha_fin' => Yii::t('app', 'Fecha Fin'),
            'Estado_id' => Yii::t('app', 'Estado ID'),
            'Responsable_id' => Yii::t('app', 'Responsable ID'),
            'Informe_id' => Yii::t('app', 'Informe ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsable()
    {
        return $this->hasOne(User::className(), ['id' => 'Responsable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'Estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInforme()
    {
        return $this->hasOne(Informe::className(), ['id' => 'Informe_id']);
    }

    /**
     * @inheritdoc
     * @return WorkflowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkflowQuery(get_called_class());
    }
    
    /**
     * 
     * @return id del registro de estado en proceso
     */
    public static function estadoEnProceso(){
    	return 3;
    }
    
    /**
     * @return id del registro de pendiente
     */
    public static function estadoPendiente(){
    	return 1;
    }
    
    /**
     * @return id del registro de finalizado
     */
    public static function estadoFinalizado(){
    	return 5;
    }

    /**
     * @return id del registro de entregado
     */
    public static function estadoEntregado(){
    	return 6;
    }


    /**
     * @return id del registro de descartado
     */
    public static function estadoDescartado(){
    	return 2;
    }
    

    /**
     * @return id del registro de pausado
     */
    public static function estadoPausado(){
    	return 4;
    }

    public static function getTieneEstadoEntregado($informe_id)
    {        
        $rta=false;
        $query = new Query;
        $query->select(['Workflow.id'])  
            ->from('Workflow')
            ->join(	'join', 
                    'Estado', 
                    'Workflow.Estado_id=Estado.id'
            )
            ->where(["Workflow.Informe_id"=>$informe_id,"Estado.estado_final"=>1]);
                
        $command = $query->createCommand();
        $data = $command->queryAll();	
        if(!empty($data) ){
            $rta=true;
        }

        return $rta;
    }

    
    
}
