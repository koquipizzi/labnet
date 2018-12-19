<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Medico;

/**
 * MedicoSearch represents the model behind the search form about `app\models\Medico`.
 */
class MedicoSearch extends Medico
{
    /**
     * @inheritdoc
     */
    public $especialidadTexto;
    public $localidad_nombre;
    public $especialidad_nombre;
    public function rules()
    {
        return [
            [['id', 'Localidad_id', 'especialidad_id'], 'integer'],
            [['nombre', 'email', 'domicilio', 'telefono'], 'safe'],
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
        $query = Medico::find()
            ->join('INNER JOIN','Especialidad','Especialidad.id = Medico.especialidad_id')
            ->join('INNER JOIN','Localidad','Localidad.id = Medico.localidad_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort'=>[
                'attributes'=>[
                    'especialidad_id',
                    'Localidad_id',
                    'nombre',
                    'Especialidad.nombre',
                    'Localidad.nombre',
                    'domicilio',
                    'telefono',
                    'Email'
                    ],
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

        $query->andFilterWhere(['like', 'Medico.nombre', $this->nombre])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'especialidad_id', $this->especialidad_id])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio])
            ->andFilterWhere(['like', 'Especialidad.nombre', $this->especialidad_nombre])
            ->andFilterWhere(['like', 'Localidad.nombre', $this->localidad_nombre])
            ->andFilterWhere(['like', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
