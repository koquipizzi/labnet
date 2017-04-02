<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "InformeTemp".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $observaciones
 * @property string $material
 * @property string $tecnica
 * @property string $macroscopia
 * @property string $microscopia
 * @property string $diagnostico
 * @property string $Informecol
 * @property string $session_id
 * @property string $citologia
 * @property string $resultado
 * @property string $metodo
 * @property integer $Estudio_id
 * @property integer $Protocolo_id
 * @property integer $edad
 * @property string $tanda
 * @property string $titulo
 */
class InformeTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InformeTemp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Estudio_id'], 'required'],
            [['citologia'], 'string', 'max' => 1024],
            [['Estudio_id', 'Protocolo_id', 'edad','tanda'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
            [['metodo', 'resultado'], 'string', 'max' => 1024],
            [['titulo'], 'string', 'max' => 255],
            [['observaciones', 'material', 'tecnica', 'macroscopia', 'microscopia', 'diagnostico'], 'string', 'max' => 1024],
            [['Informecol'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'material' => Yii::t('app', 'Material'),
            'tecnica' => Yii::t('app', 'Tecnica'),
            'macroscopia' => Yii::t('app', 'Macroscopia'),
            'microscopia' => Yii::t('app', 'Microscopia'),
            'diagnostico' => Yii::t('app', 'Diagnostico'),
            'Informecol' => Yii::t('app', 'Informecol'),
            'Estudio_id' => Yii::t('app', 'Estudio ID'),
            'Protocolo_id' => Yii::t('app', 'Protocolo ID'),
            'titulo' => Yii::t('app', 'Título'),
        ];
    }

    /**
     * @inheritdoc
     * @return InformeTempQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InformeTempQuery(get_called_class());
    }
    /**
     * Este metodo se utiliza para visualizar el nombre del estudio seleccionado en la grid de protocolo
     * @return string name
     */
    public function getEstudio(){
        $estudio = $this->hasOne(Estudio::className(), ['id' => 'Estudio_id'])->one();
        if ($estudio)
            return $estudio->nombre;
        return '';
    }


    public function getNomencladores()
    {

        $nomencladores = "";
        if (($informeNomencladores = InformeNomencladorTemporal::find()
                ->andWhere("id_informeTemp = $this->id")
                ->asArray()->all()) !== null) {
            $informeNomencladores = ArrayHelper::getColumn($informeNomencladores, 'id_nomenclador');
            foreach ($informeNomencladores as $nomenclador){
                $r = Nomenclador::findOne(['id' => $nomenclador]);

                if(isset($r)){
                    $nomencladores .= $r->servicio;
                    $nomencladores .= ", ";
                }
                else{
                    $nomencladores .= "no tiene";
                    $nomencladores .= ", ";
                }
            }
        }
        if ( strlen ( $nomencladores ) === 0 )
            return $nomencladores;
        else if ( strlen ( $nomencladores ) < 40 )
            return substr($nomencladores, 0, -2);
    }



}
