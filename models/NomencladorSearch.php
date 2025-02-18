<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nomenclador;

/**
 * NomencladorSearch represents the model behind the search form about `app\models\Nomenclador`.
 */
class NomencladorSearch extends Nomenclador
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Prestadoras_id', 'servicio'], 'integer'],
            [['descripcion', 'servicio','Prestadoras_id'], 'safe'],
            [['valor', 'coseguro'], 'number'],
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
        $query = Nomenclador::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'sort' => [
              'attributes' => [
                    'servicio',
                    'coseguro',
                    'Prestadoras_id',
                    'valor',
                    'descripcion',
                ],
    ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'valor' => $this->valor,
            'Prestadoras_id' => $this->Prestadoras_id,
            'coseguro' => $this->coseguro,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'servicio', $this->servicio]);

        

        return $dataProvider;
    }
}
