<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Procedencia;

/**
 * ProcedenciaSearch represents the model behind the search form about `app\models\Procedencia`.
 */
class ProcedenciaSearch extends Procedencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Localidad_id'], 'integer'],
            [['telefono','domicilio','mail','descripcion','Localidad_id'], 'string'],
            [['telefono','domicilio','mail','descripcion','Localidad_id'], 'safe'],];
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
        $query = Procedencia::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'Localidad_id',
                    'descripcion',
                    'mail',
                    'domicilio',
                    'telefono',

                ]
            ]
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
            'Localidad_id' => $this->Localidad_id,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio])
            ->andFilterWhere(['like', 'mail', $this->mail])
              ->andFilterWhere(['like', 'Localidad_id', $this->Localidad_id])
             ->andFilterWhere(['like', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
