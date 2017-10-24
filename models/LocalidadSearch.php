<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Localidad;
/**
 * LocalidadSearch represents the model behind the search form about `app\models\Localidad`.
 */
class LocalidadSearch extends Localidad
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','caracteristica_telefonica'], 'integer'],
            [['nombre', 'cp'], 'safe'],
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
        $query = Localidad::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' =>  50]
             
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['like', 'caracteristica_telefonica', $this->caracteristica_telefonica])
              ->andFilterWhere(['like', 'cp', $this->cp]);
        return $dataProvider;
    }
}