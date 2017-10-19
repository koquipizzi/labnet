<?php

namespace app\models;
use Empathy\Validators\DateTimeCompareValidator;
use Yii;
use app\models\Informe;
use app\models\PacientePrestadora;
 use \Datetime;
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
                    [['anio'], 'string', 'max' => 4],
                    [['letra'], 'string', 'max' => 1],
        //            [['nombre'], 'string'],
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
    	$secuncia = sprintf("%06d", $this->nro_secuencia);
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




}
