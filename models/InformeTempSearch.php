<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InformeTemp;

/**
 * InformeTempSearch represents the model behind the search form about `app\models\InformeTemp`.
 */
class InformeTempSearch extends InformeTemp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Estudio_id', 'Protocolo_id'], 'integer'],
            [['descripcion', 'observaciones', 'material', 'tecnica', 'macroscopia', 'microscopia', 'diagnostico', 'Informecol', 'session_id', 'create_date'], 'safe'],
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
         $session=Yii::$app->session->getId();
         $query = (new \yii\db\Query())
                ->select('*')
                ->from('InformeTemp')
                ->where(['session_id'=>$session,'tanda'=>$tanda]); 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);



        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'Estudio_id' => $this->Estudio_id,
            'Protocolo_id' => $this->Protocolo_id,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'tecnica', $this->tecnica])
            ->andFilterWhere(['like', 'macroscopia', $this->macroscopia])
            ->andFilterWhere(['like', 'microscopia', $this->microscopia])
            ->andFilterWhere(['like', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['like', 'Informecol', $this->Informecol])
            ->andFilterWhere(['like', 'session_id', $this->session_id]);

        return $dataProvider;
    }
    
    
     public function getByID($id)
     {
            return $this->find()->where(['session_id' => $id])->all();
                    
    }
    
}
