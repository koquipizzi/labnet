<?php

namespace app\models;
use Empathy\Validators\DateTimeCompareValidator;
use Yii;
use app\models\Informe;
use app\models\PacientePrestadora;
use \Datetime;
use yii\db\Query;
/**
 * This is the model class for table "Protocolo".
 *
 * @property integer $id
 * @property string $fecha_entrada
 * @property string $fecha_entrega
 * @property string $anio
 * @property string $nombre
* @property string $codigo
 * @property string $letra
 * @property integer $nro_secuencia
 * @property string $registro
 * @property string $observaciones|
 * @property integer $Medico_id
 * @property integer $Procedencia_id
 * @property integer $Paciente_prestadora_id
 * @property integer $FacturarA_id
 * @property integer $numero_hospitalario
 *
 * @property Informe[] $informes
 * @property Medico $medico
 * @property PacientePrestadora $pacientePrestadora
 * @property Prestadoras $facturarA
 * @property Procedencia $procedencia

 */
class Protocolo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Protocolo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['nro_secuencia', 'Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id','numero_hospitalario'], 'integer'],
                    [['Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id','fecha_entrega'],'required'],
                    [['letra','nro_secuencia'],'required'],
                    [['anio'], 'string', 'max' => 4],
                    [['letra'], 'string', 'max' => 1],
                    [['registro'], 'string', 'max' => 45],
                    [['observaciones'], 'string', 'max' => 255],
                    [['Medico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['Medico_id' => 'id']],
                    [['Paciente_prestadora_id'], 'exist', 'skipOnError' => true, 'targetClass' => PacientePrestadora::className(), 'targetAttribute' => ['Paciente_prestadora_id' => 'id']],
                    [['FacturarA_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadoras::className(), 'targetAttribute' => ['FacturarA_id' => 'id']],
                    [['Procedencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Procedencia::className(), 'targetAttribute' => ['Procedencia_id' => 'id']],
                    ['fecha_entrada', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '<='],
                    ['fecha_entrega', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '>='],

            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha_entrada' => Yii::t('app', 'Fecha de Entrada'),
            'fecha_entrega' => Yii::t('app', 'Fecha de Entrega'),
            'anio' => Yii::t('app', 'Año'),
            'letra' => Yii::t('app', 'Letra'),
            'nro_secuencia' => Yii::t('app', 'Nro. Secuencia'),
            'registro' => Yii::t('app', 'Registro'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'Medico_id' => Yii::t('app', 'Médico'),
            'Procedencia_id' => Yii::t('app', 'Procedencia'),
            'Paciente_prestadora_id' => Yii::t('app', 'Paciente'),
            'FacturarA_id' => Yii::t('app', 'Facturar A'),
            'Pacienteprestadora' => Yii::t('app', 'Datos Paciente'),
            'numero_hospitalario' => Yii::t('app', 'Número Hospitalario'),
            'Codigo' => Yii::t('app', 'Código'),

        ];
    }




    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllInformes($id)
    {
        return Informe::findAll(["Protocolo_id"=>$id]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformes()
    {
        return $this->hasMany(Informe::className(), ['Protocolo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedico()
    {
        return $this->hasOne(Medico::className(), ['id' => 'Medico_id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturarA()
    {
        return $this->hasOne(Prestadoras::className(), ['id' => 'FacturarA_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedencia()
    {
        $procedencia=  $this->hasOne(Procedencia::className(), ['id' => 'Procedencia_id']);
        return $procedencia;
    }


    public function getPacienteprestadora()
    {
        $paciente= $this->hasOne(ViewPacientePrestadora::className(), ['id' => 'Paciente_prestadora_id'])->one();
        return $paciente->nombreDniDescripcionNroAfiliado;
    }

    public function getPacienteDoc()
    {
        $paciente= $this->hasOne(ViewPacientePrestadora::className(), ['id' => 'Paciente_prestadora_id'])->one();
        $pac = $paciente->nro_documento;
        return $pac;
    }

    public function getPacienteMail()
    {
        $pacientePrestadora= $this->hasOne(PacientePrestadora::className(), ['id' => 'Paciente_prestadora_id'])->one();
        $paciente= Paciente::find()->where(['id' => $pacientePrestadora->Paciente_id])->one();
        return $paciente->email;
    }

    public function getPacienteText()
    {
        $paciente= $this->hasOne(ViewPacientePrestadora::className(), ['id' => 'Paciente_prestadora_id'])->one();
        $pac = substr($paciente->nombreDniDescripcionNroAfiliado, 0, strpos($paciente->nombreDniDescripcionNroAfiliado, '('));
        return $pac;
    }

    public function getPacienteTexto()
    {
        $pacientePrestadora= $this->hasOne(PacientePrestadora::className(), ['id' => 'Paciente_prestadora_id'])->one();
        $paciente= Paciente::find()->where(['id' => $pacientePrestadora->Paciente_id])->one();
        return $paciente->nombre;
    }

    public function getPacienteEdad()
    {
        $paciente= $this->hasOne(ViewPacientePrestadora::className(), ['id' => 'Paciente_prestadora_id'])->one();
        $fecha1 = $paciente->fecha_nacimiento;
        $fecha2 = date("Y-m-d");
        //$fecha = $fecha2 - $fecha1;
        $date1 = new DateTime($fecha1);
        $date2 = new DateTime("now");
        $diff = $date1->diff($date2);
        $d=(string)$diff->format('%y');
        return $d;
    }


    public function getCodigo()
    {
    	$secuncia = sprintf("%07d", $this->nro_secuencia);
        $codigo= substr($this->anio,-2).$this->letra."-".$secuncia;
        return $codigo;
    }
    public function getNroSecuencia()
    {
    	$secuncia = sprintf("%06d", $this->nro_secuencia);
    	return $secuncia;

    }

    public function getFechaEntrega()
    {
        $fecha= $this->fecha_entrega;
        $arr = explode('-',$fecha);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }


    public function getFechaEntrada()
    {
        $fecha= $this->fecha_entrada;
        $arr = explode('-',$fecha);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }

    public function getFechaEntregaOrdenada()
    {
        $fecha= $this->fecha_entrega;
        $arr = explode('-',$fecha);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }


    public function getCobertura()
    {
    	$pacientePrestadora_id= Protocolo::find('Paciente_prestadora_id')->where("id=$this->id")->one()['Paciente_prestadora_id'];
        $cobertura_id = PacientePrestadora::find()->where("id=$pacientePrestadora_id")->one()['Prestadoras_id'];
        $cobertura = Prestadoras::find()->where("id=$cobertura_id")->one()['descripcion'];
        return $cobertura;
    }

      public function getNextNroSecuenciaByLetra($letra,$anio){
        $query = new Query;
        $query	->select(['max(nro_secuencia) as nro_secuencia,anio'])  
                ->from('Protocolo')                
                ->where(["Protocolo.letra"=>$letra,"Protocolo.anio"=>$anio])                          
                ->groupBy(['Protocolo.letra']);
        $command = $query->createCommand();
        $data = $command->queryAll();

        if(empty($data) || !is_array($data) || ( !array_key_exists("anio",$data[0]) && !array_key_exists("nro_secuencia",$data[0]) ) ){
             throw new \yii\base\Exception("Elija el valor inicial para Nro.Secuencia de la letra {$letra}.");         
        }
        $nro_secuencia=$data[0]["nro_secuencia"];
        if($data[0]["anio"]<$anio){
            $nro_secuencia=sprintf("%07d",0);
            
        }else{
           $nro_secuencia=sprintf("%07d",($nro_secuencia+1) );
        }  
        return $nro_secuencia;
    } 

    public function existeNumeroSecuenciaUpdate(){
        $modelProtocolo= Protocolo::find()->where(["anio"=>$this->anio,"nro_secuencia"=>$this->nro_secuencia, "letra"=>$this->letra])->one();
        $existe=false;
        if(!empty( $modelProtocolo) ){
            $existe=true;
        }

        $modelProtocolo= Protocolo::find()->where(["anio"=>$this->anio,"nro_secuencia"=>$this->nro_secuencia, "letra"=>$this->letra, "id"=>$this->id])->one();
        if(!empty( $modelProtocolo) ){
            $existe=false;
        }

        return $existe;
    }


    public function existeNumeroSecuencia($anio =null,$letra = null,$nro_secuencia = null){

        $modelProtocolo= Protocolo::find()->where(["anio"=>$this->anio,"nro_secuencia"=>$this->nro_secuencia, "letra"=>$this->letra])->one();
        $existe=false;
        if(!empty( $modelProtocolo) ){
            $existe=true;
        }
        return $existe;
    }
    public static function existeNumeroSecuenciaParams($anio,$letra,$nro_secuencia){
        if( empty($anio) || empty($letra) || empty($nro_secuencia)){
              throw new \yii\base\Exception("Error, parametros falntantes"); 
        }
        $modelProtocolo= Protocolo::find()->where(["anio"=>$anio,"nro_secuencia"=>$nro_secuencia, "letra"=>$letra])->one();
        $existe=false;
        if(!empty( $modelProtocolo) ){
            $existe=true;
        }
        return $existe;
    }   
   public static function existeNumeroSecuenciaParamsUpdate($anio,$letra,$nro_secuencia,$protocolo_id){
        if( empty($anio) || empty($letra) || empty($nro_secuencia)){
              throw new \yii\base\Exception("Error, parametros falntantes"); 
        }
        $modelProtocolo= Protocolo::find()->where(["anio"=>$anio,"nro_secuencia"=>$nro_secuencia, "letra"=>$letra])->one();
        $existe=false;
        if(!empty( $modelProtocolo) ){
            $existe=true;
        }
              $modelProtocolo= Protocolo::find()->where(["anio"=>$anio,"nro_secuencia"=>$nro_secuencia, "letra"=>$letra,"id"=>$protocolo_id])->one();
        if(!empty( $modelProtocolo) ){
            $existe=false;
        }
        return $existe;
    }         

    public function  getPacientePrestadoraArray(){
        //el paciente prestadora configurado
        $query = new Query;
        $query->select(['Paciente_prestadora.id, CONCAT(Paciente.nro_documento," (",Paciente.nombre,") ", Prestadoras.descripcion ) descripcion'])  
            ->from( 'Prestadoras')
            ->join(	'join', 
                    'Paciente_prestadora',
                    'Prestadoras.id=Paciente_prestadora.prestadoras_id'
            )       
            ->join(	'join', 
                    'Paciente',
                    'Paciente.id=Paciente_prestadora.paciente_id'
            )                   
            ->where(["Paciente_prestadora.id"=>$this->Paciente_prestadora_id]);
                
        $command = $query->createCommand();
        $data = $command->queryAll();	
        $arrayData=array();
        if( !empty($data) and is_array($data) ){ //and array_key_exists('detallepedidopieza',$data) and array_key_exists('detalle_pedido_id',$data)){
            foreach ($data as $key => $arrayPacientePrestadora) {
                 $arrayData[$arrayPacientePrestadora['id']]=$arrayPacientePrestadora['descripcion'];   
            }
        }
        //todas los pacientes prestadoras
        $query = new Query;
        $query->select(['Paciente_prestadora.id, CONCAT(Paciente.nro_documento," (",Paciente.nombre,") ", Prestadoras.descripcion ) descripcion'])  
            ->from( 'Prestadoras')
            ->join(	'join', 
                    'Paciente_prestadora',
                    'Prestadoras.id=Paciente_prestadora.prestadoras_id'
            )       
            ->join(	'join', 
                    'Paciente',
                    'Paciente.id=Paciente_prestadora.paciente_id'
            );
                
        $command = $query->createCommand();
        $data = $command->queryAll();	
        if( !empty($data) and is_array($data) ){ //and array_key_exists('detallepedidopieza',$data) and array_key_exists('detalle_pedido_id',$data)){
            foreach ($data as $key => $arrayPacientePrestadora) {
                 $arrayData[$arrayPacientePrestadora['id']]=$arrayPacientePrestadora['descripcion'];   
            }
        }        

        return $arrayData;
    }


    public function eliminarInformes(){        
        $modelInformes= Informe::find()->where(["Protocolo_id"=>$this->id])->all();
        try{   
            if(!empty($modelInformes) ) {          
                foreach ($modelInformes as $modelInformesArray => $inf) {
                    Informe::eliminarInforme($inf->id);                    
                }
            }
        }catch (Exception $e) {
            throw new Exception("Error, delete protocolo's informes . Protocolo id {$this->id} ");
        }
    }

}
