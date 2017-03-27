<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PacientePrestadora;

/**
 * PacientePrestadoraSearch represents the model behind the search form about `app\models\PacientePrestadora`.
 */
class PacientePrestadoraSearch extends PacientePrestadora
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Paciente_id', 'Prestadoras_id'], 'integer'],
            [['nro_afiliado'], 'safe'],
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
    public function search($params, $paciente_id)
    {
        $query = PacientePrestadora::find();

        // add conditions that should always apply here
        $query = (new \yii\db\Query())
                ->select('*')
                ->from('Paciente_prestadora')
                ->where(['Paciente_id'=>$paciente_id]); 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'Paciente_id' => $this->Paciente_id,
            'Prestadoras_id' => $this->Prestadoras_id,
        ]);

        $query->andFilterWhere(['like', 'nro_afiliado', $this->nro_afiliado]);

        return $dataProvider;
    }
    
}
