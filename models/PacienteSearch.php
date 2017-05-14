<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paciente;

/**
 * PacienteSearch represents the model behind the search form about `app\models\Paciente`.
 */
class PacienteSearch extends Paciente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Tipo_documento_id', 'Localidad_id'], 'integer'],
            [['nombre', 'nro_documento', 'sexo', 'fecha_nacimiento', 'telefono', 'email', 'domicilio'], 'safe'],
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
        $query = Paciente::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort'=> ['defaultOrder' => ['nombre'=> SORT_ASC]]
        ]);

        //$this->load($params);

         // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_nacimiento' => $this->fecha_nacimiento,
        //    'Tipo_documento_id' => $this->Tipo_documento_id,
       //     'Localidad_id' => $this->Localidad_id,
       ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'nro_documento', $this->nro_documento])
        //    ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
       //     ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio]);
        return $dataProvider;
    }

    public function searchPacPrest($params)
    {
        $query = "
        			Select Paciente.*,
                            Paciente.id as PacienteId,
                           Paciente_prestadora.id as pacprest,
                           Prestadoras.descripcion as nombre_prest,
                           concat(Prestadoras.descripcion,' - ', Paciente_prestadora.nro_afiliado) as nombre_prest_nro
                    From Paciente
                            left JOIN Paciente_prestadora ON (Paciente.id = Paciente_prestadora.Paciente_id)         
                            left JOIN Prestadoras ON (Prestadoras.id = Paciente_prestadora.Prestadoras_id)                 
                   
                    ";
        if (isset($params['PacienteSearch']['nombre']) && ($params['PacienteSearch']['nombre'] <> "") )
            $query = $query." where Paciente.nombre like '%".$params['PacienteSearch']['nombre']."%'";
        
     //   $consultaCant = "Select Count(Paciente.id) as total From Paciente";
        $consultaCant = 'SELECT count(tt.PacienteId) as total FROM ('.$query.') as tt';
     // return total items count for this sql query
       // $itemsCount = \Yii::$app->db->createCommand($consulta)->queryScalar();
        
        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];  

        // build a SqlDataProvider with a pagination with 10 items for page
     //   $query = $query." group by Paciente.nombre ";
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'sort' => [
                 'defaultOrder' => ['nombre' => SORT_ASC],
                'attributes' => [
                    'nombre' => [
                            'asc' => ['Paciente.nombre' => SORT_ASC],
                            'desc' => ['Paciente.nombre' => SORT_DESC],
                        ],        
                ],
            ],
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
        return $dataProvider;

    }


}
