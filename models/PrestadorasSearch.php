<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prestadoras;
use yii\data\ArrayDataProvider;

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
            [['descripcion', 'telefono', 'domicilio', 'email', 'facturable'], 'safe'],
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
           $query =  Prestadoras::find()->where(['cobertura'=>1])->all();
//         $query = (new \yii\db\Query())->select('*')->from('Prestadoras')->where(['cobertura'=>1]);
        }elseif ($tipoDeEntidad==="F"){
            $query =  Prestadoras::find()->where(['cobertura'=>0])->all();
//          $query = (new \yii\db\Query())->select('*')->from('Prestadoras')->where(['cobertura'=>0]);
        }



        // add conditions that should always apply here

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//         grid filtering conditions
//        $query->andFilterWhere([
//          'id' => $this->id,
//            'Localidad_id' => $this->Localidad_id,
//            'Tipo_prestadora_id' => $this->Tipo_prestadora_id,
//        ]);
//
//        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
//            ->andFilterWhere(['like', 'telefono', $this->telefono])
//            ->andFilterWhere(['like', 'domicilio', $this->domicilio])
//            ->andFilterWhere(['like', 'email', $this->email])
//            ->andFilterWhere(['like', 'facturable', $this->facturable]);

        return $dataProvider;
    }
}
