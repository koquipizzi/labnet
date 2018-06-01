<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use Empathy\Validators\DateTimeCompareValidator;
use Yii;

/**
 * This is the model class for table "Paciente".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $nro_documento
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property string $telefono
 * @property string $email
 * @property integer $Tipo_documento_id
 * @property integer $Localidad_id
 * @property string $domicilio
 * @property string $hc
 *
 * @property Localidad $localidad
 * @property TipoDocumento $tipoDocumento
 * @property PacientePrestadora[] $pacientePrestadoras
 */
class Paciente extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Paciente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento'], 'safe'],
            [['Tipo_documento_id', 'Localidad_id', 'fecha_nacimiento'], 'required'],
            [['Tipo_documento_id', 'Localidad_id','id_old'], 'integer'],
            [['nombre'], 'string', 'max' => 200],
            //[['nombre'], 'required'],
            ['email', 'email' ],
            [['nro_documento'], 'integer'],
            [['nro_documento'], 'required'],
            [['sexo'], 'string', 'max' => 1],
            [['telefono'], 'string'],
            [[ 'hc'], 'string', 'max' => 200],
            [['domicilio'], 'string', 'max' => 45],
            [['Localidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['Localidad_id' => 'id']],
            [['Tipo_documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDocumento::className(), 'targetAttribute' => ['Tipo_documento_id' => 'id']],
            [['notas'], 'string', 'max' => 512],
            ['fecha_nacimiento', DateTimeCompareValidator::className(), 'compareValue' => date('Y-m-d'), 'operator' => '<='],
            ['fecha_nacimiento', DateTimeCompareValidator::className(), 'compareValue' => $this->edad_permitida(), 'operator' => '>='],

            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'nro_documento' => Yii::t('app', 'Nro Documento'),
            'sexo' => Yii::t('app', 'Género'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'telefono' => Yii::t('app', 'Teléfono'),
            'email' => Yii::t('app', 'Email'),
            'Tipo_documento_id' => Yii::t('app', 'Tipo Documento'),
            'Localidad_id' => Yii::t('app', 'Localidad'),
            'domicilio' => Yii::t('app', 'Domicilio'),
            'notas' => Yii::t('app', 'Notas'),
            'hc' => Yii::t('app', 'Nro Historia Clínica'),
        ];
    }


    public function edad_permitida(){
            $fecha = date('Y-m-j');
            $nuevafecha = strtotime ( '-110 year' , strtotime ( $fecha ) ) ;
            $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
            return $nuevafecha;
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
    public function getTipoDocumento()
    {
        return $this->hasOne(TipoDocumento::className(), ['id' => 'Tipo_documento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientePrestadoras()
    {
        return $this->hasMany(PacientePrestadora::className(), ['Paciente_id' => 'id']);
    }

    public function getLocalidadTexto()
    {
        $localidad = $this->hasOne(Localidad::className(), ['id' => 'Localidad_id'])->one();
        if ($localidad)
            return $localidad->nombre;
        return '';
    }

    public function getGeneroTexto()
    {
        $gen = $this->hasOne(Sexo::className(), ['id' => 'sexo'])->one();
        if ($gen)
            return $gen->descripcion;
        return '';
    }

    // you need a getter for select2 dropdown
    public function getdropPrestadoras()
    {
        $data = Prestadoras::find()->asArray()->all();
        return ArrayHelper::map($data, 'id', 'descripcion');
    }

    // You will need a getter for the current set o Acervo in this Tema
    public function getPrestadorasIds(){
          $data =  \yii\helpers\ArrayHelper::getColumn(
          PacientePrestadora::find()->asArray()->all(), 'Prestadoras_id');
          return $data;
    }

    public function getPrestadoras(){
        return $this->hasMany(Prestadoras::className(), ['id' => 'prestadora_id'])->viaTable('paciente_prestadora', ['paciente_id' => 'id']);
    }
    
    public function getInformes(){
        $query = "SELECT
                           Estudio.nombre as tipo_estudio
                          ,Protocolo.codigo as codigo_protocolo
                          ,Protocolo.fecha_entrada as fecha_protocolo
                          ,Medico.nombre as medico_nombre
                          ,Medico.id as medico_id
                          ,Protocolo.id as protocolo_id
                          ,Informe.id as informe_id
                          ,Protocolo.observaciones as observaciones_administrativas
                    FROM Informe
                    JOIN Estudio  on (Estudio.id = Informe.Estudio_id)
                    JOIN Protocolo ON (Informe.Protocolo_id = Protocolo.id)
                    JOIN Paciente_prestadora ON (Paciente_prestadora.id = Protocolo.Paciente_prestadora_id)
                    JOIN Medico on (Medico.id = Protocolo.Medico_id)
                    WHERE Paciente_prestadora.Paciente_id = {$this->id}";
        
        $count = \Yii::$app->db->createCommand("
                                                    SELECT  count(Estudio.nombre)
                                                    FROM Informe
                                                    JOIN Estudio  on (Estudio.id = Informe.Estudio_id)
                                                    JOIN Protocolo ON (Informe.Protocolo_id = Protocolo.id)
                                                    JOIN Paciente_prestadora ON (Paciente_prestadora.id = Protocolo.Paciente_prestadora_id)
                                                    JOIN Medico on (Medico.id = Protocolo.Medico_id)
                                                    WHERE Paciente_prestadora.Paciente_id = {$this->id}
                                                ")->queryAll();
    
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'tipo_estudio' => [
                        'default' => SORT_DESC,
                    ],
                    'codigo_protocolo' => [
                        'default' => SORT_DESC,
                    ],
                    'fecha_protocolo' => [
                        'default' => SORT_DESC,
                    ],
                    'medico_nombre' => [
                        'default' => SORT_DESC,
                    ],
                ],
            ],
            'pagination' => ['pageSize' => 10],
        ]);
        
        return $dataProvider;
    }
    
    //funcion que me devuelve un data provider con las prestadoras del paciente
    public function getPacientePrestadoraDP(){
        $query = PacientePrestadora::find()->where(['Paciente_id' => $this->id]);
    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' =>  50]
    
        ]);
        
        return $dataProvider;
    }
    
}
