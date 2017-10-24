<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paciente;
use yii\db\Expression;
/**
 * PacienteSearch represents the model behind the search form about `app\models\Paciente`.
 */
class PacienteSearch extends Paciente
{
public $nombre_prest_nro;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Tipo_documento_id', 'Localidad_id'], 'integer'],
            [['nombre', 'nro_documento', 'sexo', 'fecha_nacimiento', 'telefono', 'email', 'domicilio','nombre_prest_nro'], 'safe'],
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



    private function paramExists($params, $key) {
        return
            is_array($params)
            && array_key_exists($key, $params)
            && (!empty($params[$key]));
    }

    private function addWhereSentence($where, $sentence, $connector = 'AND') {
        if(empty($where))
            return $sentence;
        return " {$where} {$connector} {$sentence} ";
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







  /**
    * Filtro de Nombre
    */
    private function nombreFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'telefono')) {
            $queryParams[':telefono'] = "%".$params['telefono']."%";
            $where = $this->addWhereSentence($where, "Paciente.telefono like :telefono");
        }
    }
    



    /**
    * Filtro de Nombre
    */
    private function telefonoFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'nombre')) {
            $queryParams[':nombre'] = "%".$params['nombre']."%";
            $where = $this->addWhereSentence($where, "Paciente.nombre like :nombre");
        }
    }
    

    /**
    * Filtro de numero de documento
    */
    private function coberturaNroAfiliadoFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'nombre_prest_nro')) {
            $queryParams[':nombre_prest_nro'] = "%".$params['nombre_prest_nro']."%";
            $where = $this->addWhereSentence($where, "pp.nombre_prest_nro like :nombre_prest_nro");
        }
    }


    /**
    * Filtro de numero de documento
    */
    private function nroDocumentoFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'nro_documento')) {
            $queryParams[':nro_documento'] = "%".$params['nro_documento']."%";
            $where = $this->addWhereSentence($where, "Paciente.nro_documento like :nro_documento");
        }
    }
    
    
    public function searchPacPrest($params)
    {

        $queryParams = [];
        $where = '';
        $formParams = [];
        if(array_key_exists('PacienteSearch',$params)) {
            $formParams = $params['PacienteSearch'];
        }

        $fieldList = "
					Paciente.id,
                    Paciente.nro_documento,
                    Paciente.telefono,
                    Paciente.nombre,
                    Paciente.id as PacienteId,
                    pp.pacprest,
                    pp.nombre_prest,
                    pp.nombre_prest_nro
                     ";
        $fromTables = "
                    Paciente 
                    left join
                    (   select
							 concat(Prestadoras.descripcion,' - ', Paciente_prestadora.nro_afiliado) as nombre_prest_nro	,
                              Paciente_prestadora.Paciente_id,
                              Paciente_prestadora.id as pacprest,
                              Prestadoras.descripcion as nombre_prest,
                              Paciente_prestadora.nro_afiliado,
                              Prestadoras.descripcion
                        from  Paciente_prestadora       
                        left JOIN Prestadoras ON (Prestadoras.id = Paciente_prestadora.Prestadoras_id) 
                     ) as pp  on (Paciente.id=pp.pacprest)

                    ";

        $this->nombreFilter($formParams, $where, $queryParams);
        $this->nroDocumentoFilter($formParams, $where, $queryParams);
        $this->telefonoFilter($formParams, $where, $queryParams);
        $this->coberturaNroAfiliadoFilter($formParams, $where, $queryParams);
    
       if(!empty($where)) {
            $where = " WHERE {$where} ";
        }

        $query = "
            SELECT {$fieldList}
            FROM {$fromTables}
            {$where}
        ";
        $consultaCant = "
            SELECT count(*) as total
            FROM {$fromTables}
            {$where}
        ";
        
        $itemsCount = Yii::$app->db->createCommand(
            $consultaCant, 
            $queryParams
        )->queryScalar();
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'params' => $queryParams,
             'sort' => [
                'defaultOrder' => ['nombre' => SORT_ASC],
                'attributes' => [
                     'nombre',
                     'telefono',
                     'nombre_prest_nro',
                    'nro_documento' => [
                        'asc' => ['Paciente.nro_documento' => SORT_ASC],
                        'desc' => ['Paciente.nro_documento' => SORT_DESC],
                    ],                 
                    
                ],
            ],
            'totalCount' => $itemsCount,
            'key'        => 'id' ,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);

        
              return $dataProvider;
        

    }







}
