<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "View_Paciente_Prestadora".
 *
 * @property integer $id
 * @property string $nombreDescripcionNroAfiliado
 * @property string $nro_documento
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property string $telefono_paciente
 * @property string $email_paciente
 * @property integer $Tipo_documento_id
 * @property integer $localidad_paciente
 * @property string $domicilio_paciente
 * @property string $telefono_prestadora
 * @property string $domicilio_prestadora
 * @property string $email_prestadora
 * @property integer $localidad_prestadora
 * @property string $facturable
 * @property integer $Tipo_prestadora_id
 */
class ViewPacientePrestadora extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'View_Paciente_Prestadora';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Tipo_documento_id', 'localidad_paciente', 'localidad_prestadora', 'Tipo_prestadora_id'], 'integer'],
            [['fecha_nacimiento'], 'safe'],
            [['Tipo_documento_id', 'localidad_paciente', 'localidad_prestadora', 'Tipo_prestadora_id'], 'required'],
            [['nombreDescripcionNroAfiliado'], 'string', 'max' => 242],
            [['nro_documento'], 'string', 'max' => 10],
            [['sexo', 'facturable'], 'string', 'max' => 1],
            [['telefono_paciente', 'telefono_prestadora'], 'string', 'max' => 15],
            [['email_paciente', 'email_prestadora',  'nro_documento'], 'string', 'max' => 30],
            [['domicilio_paciente', 'domicilio_prestadora'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombreDescripcionNroAfiliado' => Yii::t('app', 'Nombre Descripcion Nro Afiliado'),
            'nro_documento' => Yii::t('app', 'Nro Documento'),
            'sexo' => Yii::t('app', 'Sexo'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'telefono_paciente' => Yii::t('app', 'Telefono Paciente'),
            'email_paciente' => Yii::t('app', 'Email Paciente'),
            'Tipo_documento_id' => Yii::t('app', 'Tipo Documento ID'),
            'localidad_paciente' => Yii::t('app', 'Localidad Paciente'),
            'domicilio_paciente' => Yii::t('app', 'Domicilo Paciente'),
            'telefono_prestadora' => Yii::t('app', 'Telefono Prestadora'),
            'domicilio_prestadora' => Yii::t('app', 'Domicilio Prestadora'),
            'email_prestadora' => Yii::t('app', 'Email Prestadora'),
            'localidad_prestadora' => Yii::t('app', 'Localidad Prestadora'),
            'facturable' => Yii::t('app', 'Facturable'),
            'Tipo_prestadora_id' => Yii::t('app', 'Tipo Prestadora ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return ViewPacientePrestadoraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ViewPacientePrestadoraQuery(get_called_class());
    }
    
    
    public function getPacientePrestadora()
    {       
        $pacientePrestadora = $this->hasOne(ViewPacientePrestadora::className(), ['id' => 'id_paceintePrestadora'])->one();
        if ($pacientePrestadora)
            return $pacientePrestadora->nombre;    
        return 'asda';
    }

}
