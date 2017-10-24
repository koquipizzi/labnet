<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prestadoras;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\db\Query;
/**
 * PrestadorasSearch represents the model behind the search form about `app\models\Prestadoras`.
 */
class PrestadorasSearch extends Prestadoras
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Localidad_id', 'Tipo_prestadora_id'], 'integer'],
            [['descripcion', 'telefono', 'domicilio', 'email', 'facturable','Localidad_id'], 'safe'],
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
     * @param array $params, $tipoDeEntidad default C , or else F
     *
     * @return ActiveDataProvider
     */
    public function search($params,$tipoDeEntidad="C")
    {

        if($tipoDeEntidad==="C"){
          $query = (new Query())
          ->select('Localidad.nombre as nombreLoc, Prestadoras.*')
          ->from('Prestadoras')->where(['cobertura' => 1]);
        }elseif ($tipoDeEntidad==="F"){
            $query = (new Query())
            ->select('Localidad.nombre as nombreLoc, Prestadoras.*')
            ->from('Prestadoras')->where(['cobertura' => 0]);

        }
        $query->join('LEFT JOIN', 'Localidad', 'Localidad.id = Prestadoras.Localidad_id');

        // add conditions that should always apply here
        $sort = new Sort([
            'defaultOrder' => ['descripcion' => SORT_ASC],
            'attributes' => [
                'id',
                'domicilio',
                'descripcion'
                //'Localidad_id'
            ]
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

//         grid filtering conditions
        $query->andFilterWhere([
          'id' => $this->id,
            'Localidad_id' => $this->Localidad_id,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'facturable', $this->facturable]);

        return $dataProvider;
    }
}
