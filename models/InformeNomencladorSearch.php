<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InformeNomenclador;

/**
 * InformeNomencladorSearch represents the model behind the search form about `app\models\InformeNomenclador`.
 */
class InformeNomencladorSearch extends InformeNomenclador
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_informe', 'id_nomenclador', 'cantidad'], 'integer'],
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
    public function search($params)
    {
      //  var_dump($params); die();
        $query = InformeNomenclador::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
   //     var_dump($this->id_informe); die();

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_informe' => $this->id_informe,
            'id_nomenclador' => $this->id_nomenclador,
            'cantidad' => $this->cantidad,
        ]);

        return $dataProvider;
    }
}
