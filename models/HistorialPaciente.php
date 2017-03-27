<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Historial_paciente".
 *
 * @property integer $id
 * @property string $fecha_entrada
 * @property string $anio
 * @property string $letra
 * @property integer $nro_secuencia
 * @property string $registro
 * @property string $observaciones
 * @property integer $Medico_id
 * @property integer $Procedencia_id
 * @property integer $Paciente_prestadora_id
 * @property integer $FacturarA_id
 * @property string $fecha_entrega
 * @property string $descripcion
 * @property string $observaciones_informe
 * @property string $material
 * @property string $tecnica
 * @property string $macroscopia
 * @property string $microscopia
 * @property string $diagnostico
 * @property string $Informecol
 * @property integer $Estudio_id
 * @property integer $Protocolo_id
 * @property integer $edad
 * @property string $leucositos
 * @property string $aspecto
 * @property string $calidad
 * @property string $otros
 * @property string $flora
 * @property string $hematies
 * @property string $microorganismos
 * @property string $titulo
 * @property string $tipo
 * @property string $nombre
 * @property string $nro_documento
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property string $telefono
 * @property string $email
 * @property integer $Tipo_documento_id
 * @property integer $Localidad_id
 * @property string $domicilio
 * @property string $notas
 * @property string $hc
 * @property string $descipcion_procedencia
 * @property string $domicilio_procedencia
 * @property integer $Localidad_id_precedencia
 * @property string $telefono_procedencia
 * @property string $informacion_adicional
 * @property string $nombre_medico
 * @property string $email_medico
 * @property string $domicilio_medico
 * @property string $telefono_medico
 * @property integer $Localidad_id_medico
 * @property string $notas_medico
 * @property integer $especialidad_id
 */
class HistorialPaciente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Historial_paciente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_entrada', 'fecha_entrega', 'fecha_nacimiento'], 'safe'],
            [['nro_secuencia', 'Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id', 'Estudio_id', 'Protocolo_id', 'edad', 'Tipo_documento_id', 'Localidad_id', 'Localidad_id_precedencia', 'Localidad_id_medico', 'especialidad_id'], 'integer'],
            [['Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id', 'Estudio_id', 'Protocolo_id', 'Tipo_documento_id', 'Localidad_id', 'Localidad_id_precedencia', 'Localidad_id_medico'], 'required'],
            [['anio'], 'string', 'max' => 4],
            [['letra', 'sexo'], 'string', 'max' => 1],
            [['registro', 'Informecol', 'domicilio', 'descipcion_procedencia', 'domicilio_procedencia', 'domicilio_medico'], 'string', 'max' => 45],
            [['observaciones', 'descripcion', 'titulo'], 'string', 'max' => 255],
            [['observaciones_informe', 'material', 'tecnica', 'macroscopia', 'microscopia', 'diagnostico'], 'string', 'max' => 1024],
            [['leucositos', 'aspecto', 'calidad', 'flora', 'hematies', 'nro_documento'], 'string', 'max' => 10],
            [['otros'], 'string', 'max' => 50],
            [['microorganismos'], 'string', 'max' => 60],
            [['tipo', 'notas', 'notas_medico'], 'string', 'max' => 512],
            [['nombre'], 'string', 'max' => 150],
            [['telefono', 'telefono_medico'], 'string', 'max' => 15],
            [['email', 'hc', 'email_medico'], 'string', 'max' => 30],
            [['telefono_procedencia', 'informacion_adicional'], 'string', 'max' => 20],
            [['nombre_medico'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha_entrada' => Yii::t('app', 'Fecha Entrada'),
            'anio' => Yii::t('app', 'Anio'),
            'letra' => Yii::t('app', 'Letra'),
            'nro_secuencia' => Yii::t('app', 'Nro Secuencia'),
            'registro' => Yii::t('app', 'Registro'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'Medico_id' => Yii::t('app', 'Medico ID'),
            'Procedencia_id' => Yii::t('app', 'Procedencia ID'),
            'Paciente_prestadora_id' => Yii::t('app', 'Paciente Prestadora ID'),
            'FacturarA_id' => Yii::t('app', 'Facturar A ID'),
            'fecha_entrega' => Yii::t('app', 'Fecha Entrega'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'observaciones_informe' => Yii::t('app', 'Observaciones Informe'),
            'material' => Yii::t('app', 'Material'),
            'tecnica' => Yii::t('app', 'Tecnica'),
            'macroscopia' => Yii::t('app', 'Macroscopia'),
            'microscopia' => Yii::t('app', 'Microscopia'),
            'diagnostico' => Yii::t('app', 'Diagnostico'),
            'Informecol' => Yii::t('app', 'Informecol'),
            'Estudio_id' => Yii::t('app', 'Estudio ID'),
            'Protocolo_id' => Yii::t('app', 'Protocolo ID'),
            'edad' => Yii::t('app', 'Edad'),
            'leucositos' => Yii::t('app', 'Leucositos'),
            'aspecto' => Yii::t('app', 'Aspecto'),
            'calidad' => Yii::t('app', 'Calidad'),
            'otros' => Yii::t('app', 'Otros'),
            'flora' => Yii::t('app', 'Flora'),
            'hematies' => Yii::t('app', 'Hematies'),
            'microorganismos' => Yii::t('app', 'Microorganismos'),
            'titulo' => Yii::t('app', 'Titulo'),
            'tipo' => Yii::t('app', 'Tipo'),
            'nombre' => Yii::t('app', 'Nombre'),
            'nro_documento' => Yii::t('app', 'Nro Documento'),
            'sexo' => Yii::t('app', 'Sexo'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'telefono' => Yii::t('app', 'Telefono'),
            'email' => Yii::t('app', 'Email'),
            'Tipo_documento_id' => Yii::t('app', 'Tipo Documento ID'),
            'Localidad_id' => Yii::t('app', 'Localidad ID'),
            'domicilio' => Yii::t('app', 'Domicilio'),
            'notas' => Yii::t('app', 'Notas'),
            'hc' => Yii::t('app', 'Hc'),
            'descipcion_procedencia' => Yii::t('app', 'Descipcion Procedencia'),
            'domicilio_procedencia' => Yii::t('app', 'Domicilio Procedencia'),
            'Localidad_id_precedencia' => Yii::t('app', 'Localidad Id Precedencia'),
            'telefono_procedencia' => Yii::t('app', 'Telefono Procedencia'),
            'informacion_adicional' => Yii::t('app', 'Informacion Adicional'),
            'nombre_medico' => Yii::t('app', 'Nombre Medico'),
            'email_medico' => Yii::t('app', 'Email Medico'),
            'domicilio_medico' => Yii::t('app', 'Domicilio Medico'),
            'telefono_medico' => Yii::t('app', 'Telefono Medico'),
            'Localidad_id_medico' => Yii::t('app', 'Localidad Id Medico'),
            'notas_medico' => Yii::t('app', 'Notas Medico'),
            'especialidad_id' => Yii::t('app', 'Especialidad ID'),
        ];
    }
    
    /**
     * @author franco.a
     * obtiene de las tablas protocolo,procedencia,informe,medico,paciente 
     * las tuplas relacionadas con un informe e inserta un registro en la tabla historial usuario mediate una transaccion
     * @return string
     */
    public function registrar($id_informe){
        $informe= Informe::find()->where("id=$id_informe")->one();
        $protocolo= Protocolo::find()->where(['id'=>$informe->Protocolo_id])->one();
        $pacientePrestadora= PacientePrestadora::find()->where(['id'=>$protocolo->Paciente_prestadora_id])->one();
        $paciente= Paciente::find()->where(['id'=>$pacientePrestadora->Paciente_id])->one();
        $medico= Medico::find()->where(['id'=> $protocolo->Medico_id ])->one();
        $procedencia= Procedencia::find()->where(['id'=> $protocolo->Procedencia_id ])->one();
        $historialP=new HistorialPaciente();
       $connection = \Yii::$app->db;
       $transaction = $connection->beginTransaction();
       try {     
                foreach ($historialP as $kh=>$hv){

                     foreach ($informe as $ki=>$vi){
                         if($kh===$ki){
                             $historialP[$kh]=$vi;
                         }
                     }
                     foreach ($protocolo as $kp=>$vp){
                         if($kh===$kp){
                             $historialP[$kh]=$vp;
                         }
                     }
                     foreach ($paciente as $kpc=>$vpc){
                         if($kh===$kpc){
                             $historialP[$kh]=$vpc;
                         }
                     }
                     foreach ($medico as $km=>$vm){
                         if($kh===$km){
                             $historialP[$kh]=$vm;
                         }     
                     }
                     foreach ($procedencia as $kproc=>$vproc){
                         if($kh===$kproc){
                             $historialP[$kh]=$vproc;
                         }      
                     }
                     //parameter set manual
                   $historialP->notas_medico                 = $medico->notas;
                   $historialP->Localidad_id_medico          = $medico->Localidad_id;
                   $historialP->observaciones_informe        = $informe->observaciones;
                   $historialP->nombre_medico                = $medico->nombre;             
                   $historialP->telefono_procedencia         = $procedencia->telefono;
                   $historialP->domicilio_procedencia        = $procedencia->domicilio;

                   $historialP->email_medico                 = $medico->email;
                   $historialP->domicilio_medico             = $medico->domicilio;
                   $historialP->telefono_medico              = $medico->telefono;         
                   $historialP->Localidad_id_precedencia     = $procedencia->Localidad_id;

                 }
            $historialP->save();
            $transaction->commit();
         }  catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
    }
}
