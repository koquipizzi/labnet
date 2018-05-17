<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;


/**
 * This is the model class for table "Medico".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $email
 * @property string $especialidad
 * @property string $domicilio
 * @property string $telefono
 * @property integer $Localidad_id
 *
 * @property Localidad $localidad
 * @property Protocolo[] $protocolos
 */
class Medico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Medico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Localidad_id','nombre'], 'required'],
            [['Localidad_id', 'especialidad_id','id_old'], 'integer'],
            [['nombre'], 'string', 'max' => 150],
            [['email'], 'email'],
            [['telefono'], 'string','max' => 45], 
            [['domicilio'], 'string', 'max' => 45],     
            [['notas'], 'string', 'max' => 512],
            [['Localidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['Localidad_id' => 'id']],
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
            'email' => Yii::t('app', 'Email'),
            'especialidad_id' => Yii::t('app', 'Especialidad'),
            'domicilio' => Yii::t('app', 'Domicilio'),
            'telefono' => Yii::t('app', 'Teléfono'),
            'Localidad_id' => Yii::t('app', 'Localidad'),
            'notas' => Yii::t('app', 'Notas'),
        ];
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
    public function getProtocolos()
    {
        return $this->hasMany(Protocolo::className(), ['Medico_id' => 'id']);
    }
    
    public function getLocalidadTexto()
    {       
        $localidad = $this->hasOne(Localidad::className(), ['id' => 'Localidad_id'])->one();
        if ($localidad)
            return $localidad->nombre;
        return '';
    }
    
    
    public function getEspecialidadTexto()
    {
        $esp = $this->hasOne(Especialidad::className(), ['id' => 'especialidad_id'])->one();
        if (isset($esp) && $esp!="" )
            return $esp->nombre;
        return 'No tiene';
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
                    JOIN Medico on (Medico.id = Protocolo.Medico_id)
                    WHERE Medico.id =  {$this->id}";
        
        $count = \Yii::$app->db->createCommand("
                                                    SELECT  count(Estudio.nombre)
                                                    FROM Informe
                                                    JOIN Estudio  on (Estudio.id = Informe.Estudio_id)
                                                    JOIN Protocolo ON (Informe.Protocolo_id = Protocolo.id)
                                                    JOIN Medico on (Medico.id = Protocolo.Medico_id)
                                                    WHERE Medico.id =  {$this->id}
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
    
    
    
    
    
}
