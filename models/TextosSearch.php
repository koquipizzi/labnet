<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Textos;

/**
 * TextosSearch represents the model behind the search form about `app\models\Textos`.
 */
class TextosSearch extends Textos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'estudio_id'], 'integer'],
            [['codigo', 'material', 'tecnica', 'macro', 'micro', 'diagnos', 'observ'], 'safe'],
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
        $query = Textos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array(
                'pageSize'=>50,
            ),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'estudio_id' => $this->informe_id,
//        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'tecnica', $this->tecnica])
            ->andFilterWhere(['like', 'macro', $this->macro])
            ->andFilterWhere(['like', 'micro', $this->micro])
            ->andFilterWhere(['like', 'diagnos', $this->diagnos])
            ->andFilterWhere(['like', 'observ', $this->observ]);

        return $dataProvider;
    }
}
