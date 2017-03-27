<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Informe;
use yii\data\ArrayDataProvider;


/**
 * InformeSearch represents the model behind the search form about `app\models\Informe`.
 */
class InformeSearch extends Informe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Estudio_id', 'Protocolo_id'], 'integer'],
            [['descripcion', 'observaciones', 'material', 'tecnica', 'macroscopia', 'microscopia', 'diagnostico', 'Informecol'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$id=null)
    {

        // add conditions that should always apply here

        $dataProvider = new ArrayDataProvider([
            'allModels' =>  Informe::find()->where(['Protocolo_id'=>$id])->all(),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        return $dataProvider;
    }
    

}
