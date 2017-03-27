<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PrestadoraTemp;

/**
 * PrestadoratempSearch represents the model behind the search form about `app\models\PrestadoraTemp`.
 */
class PrestadoratempSearch extends PrestadoraTemp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Prestadora_id'], 'integer'],
            [['nro_afiliado', 'tanda'], 'safe'],
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
    public function search($params,$tanda)
    {
        $query = (new \yii\db\Query())
                ->select('*')
                ->from('PrestadoraTemp')
                ->where(['tanda'=>$tanda]); 

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

//        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'Prestadora_id' => $this->Prestadora_id,
//        ]);
//
//        $query->andFilterWhere(['like', 'nro_afiliado', $this->nro_afiliado])
//            ->andFilterWhere(['like', 'tanda', $this->tanda]);

        return $dataProvider;
    }
    
    public function getPrestadoraTexto()
    {       
        $prestadora = $this->hasOne(Prestadoras::className(), ['Prestadora_id' => 'Prestadoras_id'])->one();
        if ($prestadora)
            return $prestadora->descripcion;
        return '';
    }
}
