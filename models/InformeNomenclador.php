<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "InformeNomenclador".
 *
 * @property integer $id
 * @property integer $id_informe
 * @property integer $id_nomenclador
 * @property integer $cantidad
 *
 * @property Informe $idInforme
 * @property Nomenclador $idNomenclador
 */
class InformeNomenclador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InformeNomenclador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_informe', 'id_nomenclador','cantidad'], 'required'],
            [['id_informe', 'id_nomenclador', 'cantidad'], 'integer'],
            [['cantidad'], 'mayorACero'],
            [['id_informe'], 'exist', 'skipOnError' => true, 'targetClass' => Informe::className(), 'targetAttribute' => ['id_informe' => 'id']],
            [['id_nomenclador'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclador::className(), 'targetAttribute' => ['id_nomenclador' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_informe' => Yii::t('app', 'Id Informe'),
            'id_nomenclador' => Yii::t('app', 'Servicio'),
            'cantidad' => Yii::t('app', 'Cantidad'),
        ];
    }
    
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

     public function mayorACero($attribute,$params)
    {

       if ($this->$attribute <= 0)
          $this->addError($attribute, 'Cantidad debe ser mayor a 0');

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInforme()
    {
        return $this->hasOne(Informe::className(), ['id' => 'id_informe']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNomenclador($id)
    {
    	$fn =$this->find()->where(["informe_id"=>$id])->one();
        return $this->hasMany(Nomenclador::className(), ['id' => $fn->id]);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNomencladordesDeInforme()
    {
    	return $this->model()->with('nomenclador')->findAll();
    }
    
    
    public function getNomencladorTexto($id)
    {   
        $nom = $this->hasOne(Nomenclador::className(), ['id' => $id])->one();
        if ($nom)
            return $nom->valor;
        return '';
    }
    
    
    /**
     * @inheritdoc
     * @return InformeNomencladorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InformeNomencladorQuery(get_called_class());
    }
}
