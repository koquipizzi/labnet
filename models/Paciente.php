<?php

namespace app\models;
use yii\helpers\ArrayHelper;
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
 * @property integer $id_old
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
    public function getPrestadorasIds()
    {
       // $data = PacientePrestadora::find()->asArray()->all()
          $data =  \yii\helpers\ArrayHelper::getColumn(
          PacientePrestadora::find()->asArray()->all(), 'Prestadoras_id');
          return $data;
    }

    public function getPrestadoras()
    {
        return $this->hasMany(Prestadoras::className(), ['id' => 'prestadora_id'])->viaTable('paciente_prestadora', ['paciente_id' => 'id']);
    }

     public function afterSave($insert, $changedAttributes)
    {
//        $actualPrestadoras = [];
//        $prestadoraExists = 0; //for updates
//
//        if (isset(Yii::$app->request->post('Paciente')['PrestadorasIds']))
//            $nuevosPrestadoras  = Yii::$app->request->post('Paciente')['PrestadorasIds'];
//        else $nuevosPrestadoras = [];
//
//        if (($actualPrestadoras = PacientePrestadora::find()
//                ->andWhere("Paciente_id = $this->id")
//                ->asArray()->all()) !== null)
//                {
//                    $actualPrestadoras = ArrayHelper::getColumn($actualPrestadoras, 'Prestadoras_id');
//                    $prestadoraExists = 1; // if there is authors relations, we will work it latter
//                 }
//
//        if ($prestadoraExists == 1) { //delete colecciones y acervo
//            foreach ($actualPrestadoras as $remove) {
//              $r = PacientePrestadora::findOne(['Prestadoras_id' => $remove, 'Paciente_id' => $this->id]);
//              $r->delete();
//            }
//        }
//
//        if (!empty($nuevosPrestadoras)) { //save the relations
//          foreach ($nuevosPrestadoras as $id) {
//            //$actualTemas = array_diff($nuevosTemas, [$id]); //remove remaining authors from array
//            $r = new PacientePrestadora();
//            $r->Paciente_id = $this->id;
//            $r->Prestadoras_id = $id;
//            $r->save();
//            }
//        }


    }
}
