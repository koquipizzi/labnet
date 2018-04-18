<?php

namespace app\models;
use Empathy\Validators\DateTimeCompareValidator;
use Yii;
use app\models\Informe;
use app\models\PacientePrestadora;
use \Datetime;
use \Exception;
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
 * @property integer $id_old
 *
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
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['nro_secuencia', 'Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id','numero_hospitalario','id_old'], 'integer'],
                    [['Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id'],'required'],
                    [['letra','nro_secuencia'],'required'],
                    [['fecha_entrada','fecha_entrega'], 'safe'],
                    [['anio'], 'string', 'max' => 4],
                    [['letra'], 'string', 'max' => 1],
                    [['registro'], 'string', 'max' => 45],
                    [['observaciones'], 'string', 'max' => 255],
                    [['Medico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['Medico_id' => 'id']],
                    [['Paciente_prestadora_id'], 'exist', 'skipOnError' => true, 'targetClass' => PacientePrestadora::className(), 'targetAttribute' => ['Paciente_prestadora_id' => 'id']],
                    [['FacturarA_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prestadoras::className(), 'targetAttribute' => ['FacturarA_id' => 'id']],
                    [['Procedencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Procedencia::className(), 'targetAttribute' => ['Procedencia_id' => 'id']],
                    ['fecha_entrada', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '<=','on' => self::SCENARIO_CREATE],
                    ['fecha_entrega', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '>=','on' => self::SCENARIO_CREATE],
                    ['fecha_entrada','compare','compareAttribute'=>'fecha_entrega','operator'=>'<=','on' => self::SCENARIO_UPDATE],
                    ['fecha_entrega','compare','compareAttribute'=>'fecha_entrada','operator'=>'>=','on' => self::SCENARIO_UPDATE],
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
            'ultimo_propietario'=>Yii::t('app', 'Propietario Actual'),
            'nro_documento'=>Yii::t('app', 'Dni'),

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
    public function getNombreFacturarA()
    {
        $prestadora = Prestadoras::find()->where(['id' => $this->FacturarA_id])->one();
        $nombre="No Tiene";
        if(empty($prestadora)){
            throw new \yii\base\Exception( "Error, model prestadora." );
        }
        if(empty($prestadora->descripcion)){
            throw new \yii\base\Exception( "Error, model prestadora attribute descripcion." );
        } else{
           $nombre=$prestadora->descripcion; 
        }       
        return $nombre;
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

      /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUser()
    {
       $user="No tiene";
       $informeEstado= $this->findBySql("
    			select u.username
                from view_informe_ult_workflow vi
                     join 
                     Workflow w
                     ON(vi.id=w.id)
                     join 
                     user u
                     ON(w.Responsable_id=u.id)
                where vi.informe_id=$this->id")->asArray()->one();
        if(!empty($informeEstado)){
            $user=$informeEstado['username'];
        }      
        return $user; 
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
        $reponse = new \Datetime();
        $reponse = $reponse->format('d-m-Y');
        if  (!empty($this->fecha_entrega))
        {
            $fecha = $this->fecha_entrega;
            $arr = explode('-',$fecha);
            $reponse = $arr[2].'-'.$arr[1].'-'.$arr[0];
        }
            return $reponse;
        
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getFechaEntregaformateada()
    {
        $date = new DateTime($this->fecha_entrega);
        $fecha= $date->format('d/m/Y');
        return $fecha;
    }


    public function getFechaEntrada()
    {
        $fecha= $this->fecha_entrada;
        $arr = explode('-',$fecha);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }

    public function getFechaEntregaOrdenada()
    {
        $fecha= $this->fecha_entrada;
        $arr = explode('-',$fecha);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getFechaEntradaformateada()
    {
        $date = new DateTime($this->fecha_entrada);
        $fecha= $date->format('d/m/Y');
        return $fecha;
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
             throw new \yii\base\Exception("Elija el valor inicial para Nro.Secuencia de la letra {$letra} en el año {$anio}, sino comenzara en cero.");         
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
        if( empty($anio) || empty($letra) || empty($nro_secuencia) || empty($protocolo_id)){
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

    public function tieneInformesEntregados(){
        $modelInformes= Informe::find()->where(["Protocolo_id"=>$this->id])->all();
        $rta=true;
        try{   
            if(!empty($modelInformes) ) {          
                foreach ($modelInformes as $modelInformesArray => $inf) {
                  if(Workflow::getTieneEstadoEntregado($inf->id)){
                       throw new Exception("No se puede eliminar el protocolo. Tiene informes entregados");
                  }              
                }
            }
        }catch (Exception $e) {
            throw new Exception($e);
        }
        return $rta;          
    }    

    // public function tieneInformesEntregados(){
    //     $modelInformes= Informe::find()->where(["Protocolo_id"=>$this->id])->all();
    //     $rta=false;
    //     $msj="";  
    //     if(!empty($modelInformes) ) {          
    //         foreach ($modelInformes as $modelInformesArray => $inf) {
    //             if(Workflow::getTieneEstadoEntregado($inf->id)){
    //                 $msj="No se puede eliminar el protocolo. Tiene informes entregados";
    //                 $rta=true;
    //             }              
    //         }
    //     }
    //     return [$rta,$msj];
          
    // }





}
