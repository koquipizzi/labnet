<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Protocolo;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\db\Expression;


/**
 * ProtocoloSearch represents the model behind the search form about `app\models\Protocolo`.
 */
class ProtocoloSearch extends Protocolo
{
    public $nombre;
    public $Prestadoras_id;
    public $nro_documento;
    public $ultimo_propietario;
    public $fecha_desde;
    public $fecha_hasta;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nro_secuencia', 'Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id'], 'integer'],
            [['fecha_entrada','fecha_entrega', 'anio', 'letra', 'registro', 'observaciones', 'nombre','nro_documento', 'codigo','ultimo_propietario'], 'safe'],
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
    
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['nombre', 'nro_documento', 'codigo']);
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
    * Filtro de Estado en Workflow
    */
    private function estadoFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'estado_id')) {
            $queryParams[':estado_id'] = $params['estado_id'];
            $where = $this->addWhereSentence($where, "Workflow.Estado_id = :estado_id");
        }
    }

    /**
    * Filtro de Nro de Secuencia
    */
    private function nroSecuenciaFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'nro_secuencia')) {
            $queryParams[':nro_secuencia'] = $params['nro_secuencia'];
            $where = $this->addWhereSentence($where, "Protocolo.nro_secuencia = :nro_secuencia");
        }
    }


    /**
    * Filtro de Nombre
    */
    private function nombreFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'nombre')) {
            $queryParams[':nombre'] = "%".$params['nombre']."%";
            $where = $this->addWhereSentence($where, "Paciente.nombre like :nombre");
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
    
    /**
    * Filtro de fecha de entrada
    */
    private function fechaEntradaFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'fecha_entrada')) {
            list($fechaInicio,$fechaFin)= explode('-',$params['fecha_entrada']);
            $queryParams[':fecha_inicio_fe'] = trim($fechaInicio);
            $queryParams[':fecha_fin_fe']    = trim($fechaFin);
            $where = $this->addWhereSentence($where, "Protocolo.fecha_entrada BETWEEN STR_TO_DATE(:fecha_inicio_fe,'%d/%m/%Y') AND STR_TO_DATE(:fecha_fin_fe,'%d/%m/%Y')");
        }
    }

 
    /**
    * Filtro de fecha entrega
    */
    private function fechaEntregaFilter($params, &$where, &$queryParams) {
          if($this->paramExists($params, 'fecha_entrega')) {
            list($fechaInicio,$fechaFin)= explode('-',$params['fecha_entrega']);
            $queryParams[':fecha_inicio'] = trim($fechaInicio);
            $queryParams[':fecha_fin']    = trim($fechaFin);
            $where = $this->addWhereSentence($where, "Protocolo.fecha_entrega BETWEEN STR_TO_DATE(:fecha_inicio,'%d/%m/%Y') AND STR_TO_DATE(:fecha_fin,'%d/%m/%Y')");
        }
    }
      

   /**
    * Filtro de Código
    */
    private function codigoFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'codigo')) {
            $queryParams[':codigo'] = "%".$params['codigo']."%";
            $where = $this->addWhereSentence($where, "Protocolo.codigo like :codigo");
        }
    }
    
   /**
    * Filtro de Código
    */
    private function propietarioFilter($params, &$where, &$queryParams) {
        if($this->paramExists($params, 'ultimo_propietario')) {
            $queryParams[':ultimo_propietario'] = "%".$params['ultimo_propietario']."%";
            $where = $this->addWhereSentence($where, "u.username like :ultimo_propietario");
        }
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
       
        $queryParams = [];
        $where = '';
        $formParams = [];
        if(array_key_exists('ProtocoloSearch',$params)) {
            $formParams = $params['ProtocoloSearch'];
        }

        $fieldList = '
        distinct Protocolo.id, Informe.id as iip, 
        Protocolo.* , 
        Protocolo.id as idp,
        Paciente.nombre, 
        Paciente.nro_documento,
        Workflow.Informe_id,
        Workflow.fecha_inicio,
        Workflow.id as WorkFlow_ID,
        Workflow.Estado_id				
        ';
        $fromTables = '
            Protocolo
            LEFT JOIN Informe ON Protocolo.id = Informe.Protocolo_id
            LEFT JOIN Paciente_prestadora ON Protocolo.Paciente_prestadora_id = Paciente_prestadora.id
            LEFT JOIN Paciente ON Paciente_prestadora.Paciente_id = Paciente.id
            JOIN view_informe_ult_workflow ON Informe.id = view_informe_ult_workflow.Informe_id
            JOIn Workflow ON view_informe_ult_workflow.id = Workflow.id 
        ';
        

        $this->estadoFilter($formParams, $where, $queryParams);

        $this->nroSecuenciaFilter($formParams, $where, $queryParams);

        $this->nombreFilter($formParams, $where, $queryParams);
        
        $this->nroDocumentoFilter($formParams, $where, $queryParams);

        $this->fechaEntradaFilter($formParams, $where, $queryParams);
         
        $this->codigoFilter($formParams, $where, $queryParams);

        $this->fechaEntregaFilter($formParams, $where, $queryParams);

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
                'defaultOrder' => ['fecha_entrega' => SORT_ASC],
                'attributes' => [
                     'nombre',
                     'fecha_entrada',
                     'fecha_entrega',
                     'codigo',
                     
                    'nro_documento' => [
                        'asc' => ['Paciente.nro_documento' => SORT_ASC],
                        'desc' => ['Paciente.nro_documento' => SORT_DESC],
                    ],
                    'id' => [
                        'asc' => [new Expression('id')],
                        'desc' => [new Expression('id DESC ')],
                        'default' => SORT_DESC,
                    ],
                    
                    
                ],
            ],
            'totalCount' => $itemsCount,
            'key'        => 'id' ,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
                return $dataProvider;
            }

        return $dataProvider;
    }
    



    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    
     public function searchPendiente($params)
    {     
       
        $queryParams = [];
        $where = 'Workflow.Estado_id =1 ';
        $formParams = [];
        if(array_key_exists('ProtocoloSearch',$params)) {
            $formParams = $params['ProtocoloSearch'];
        }


        $fieldList = '
                DISTINCT(Protocolo.id ),
                Protocolo.codigo,
                Protocolo.fecha_entrada,
                Protocolo.fecha_entrega,
                Paciente.nombre,
                Paciente.nro_documento	
        ';
        $fromTables = '
                Protocolo
                LEFT JOIN
                Informe                     ON Protocolo.id = Informe.Protocolo_id
                LEFT JOIN
                Paciente_prestadora         ON Protocolo.Paciente_prestadora_id = Paciente_prestadora.id
                LEFT JOIN
                Paciente                    ON Paciente_prestadora.Paciente_id = Paciente.id
                JOIN
                view_informe_ult_workflow   ON Informe.id = view_informe_ult_workflow.Informe_id
                JOIN
                Workflow                    ON view_informe_ult_workflow.id = Workflow.id                 
        ';
	
                                                 
        $this->propietarioFilter($formParams, $where, $queryParams);	

        $this->nombreFilter($formParams, $where, $queryParams);
        
        $this->nroDocumentoFilter($formParams, $where, $queryParams);

        $this->fechaEntradaFilter($formParams, $where, $queryParams);
         
        $this->codigoFilter($formParams, $where, $queryParams);

        $this->fechaEntregaFilter($formParams, $where, $queryParams);


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
                'defaultOrder' => ['fecha_entrega' => SORT_ASC],
                'attributes' => [
                     'nombre',
                     'fecha_entrada',
                     'fecha_entrega',
                     'codigo',
                     
                    'nro_documento' => [
                        'asc' => ['Paciente.nro_documento' => SORT_ASC],
                        'desc' => ['Paciente.nro_documento' => SORT_DESC],
                    ],
                    'id' => [
                        'asc' => [new Expression('id')],
                        'desc' => [new Expression('id DESC ')],
                        'default' => SORT_DESC,
                    ],
                    
                    
                ],
            ],
            'totalCount' => $itemsCount,
            'key'        => 'id' ,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
                return $dataProvider;
            }

        return $dataProvider;
    }
    
    




    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    
     public function searchTodos($params)
    {     
       
        $queryParams = [];
        $where = '';
        $formParams = [];
        if(array_key_exists('ProtocoloSearch',$params)) {
            $formParams = $params['ProtocoloSearch'];
        }


        $fieldList = '
                DISTINCT(Protocolo.id ),
                Protocolo.codigo,
                Protocolo.fecha_entrada,
                Protocolo.fecha_entrega,
                Paciente.nombre,
                Paciente.nro_documento			
        ';
        $fromTables = '
                Protocolo
                LEFT JOIN
                Informe ON Protocolo.id = Informe.Protocolo_id
                LEFT JOIN
                Paciente_prestadora ON Protocolo.Paciente_prestadora_id = Paciente_prestadora.id
                LEFT JOIN
                Paciente ON Paciente_prestadora.Paciente_id = Paciente.id
                JOIN
                view_informe_ult_workflow ON Informe.id = view_informe_ult_workflow.Informe_id
                JOIN
                Workflow ON view_informe_ult_workflow.id = Workflow.id
        ';


        $this->nombreFilter($formParams, $where, $queryParams);
        
        $this->nroDocumentoFilter($formParams, $where, $queryParams);

        $this->fechaEntradaFilter($formParams, $where, $queryParams);
         
        $this->codigoFilter($formParams, $where, $queryParams);

        $this->fechaEntregaFilter($formParams, $where, $queryParams);

        

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
                'defaultOrder' => ['fecha_entrada' => SORT_DESC],
                'attributes' => [
                     'nombre',
                     'fecha_entrada',
                     'fecha_entrega',
                     'codigo',
                     
                    'nro_documento' => [
                        'asc' => ['Paciente.nro_documento' => SORT_ASC],
                        'desc' => ['Paciente.nro_documento' => SORT_DESC],
                    ],
                    'id' => [
                        'asc' => [new Expression('id')],
                        'desc' => [new Expression('id DESC ')],
                        'default' => SORT_DESC,
                    ],
                    
                    
                ],
            ],
            'totalCount' => $itemsCount,
            'key'        => 'id' ,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
                return $dataProvider;
            }

        return $dataProvider;
    }
    



     /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchAll($params)
    {
       $query = "
                    Select 
                            Protocolo.id,
                            Protocolo.codigo,
                            Informe.id as Informe_id,
                            Paciente.nombre as nombre ,
                            Paciente.nro_documento,
                            Protocolo.fecha_entrada,
                            Protocolo.fecha_entrega,
                            Protocolo.nro_secuencia,
                            Protocolo.anio,Protocolo.letra
                    From Protocolo
                            left JOIN Informe ON (Protocolo.id = Informe.Protocolo_id)
                            left  JOIN Paciente_prestadora ON (Protocolo.Paciente_prestadora_id = Paciente_prestadora.id)
                            left JOIN Paciente ON (Paciente_prestadora.Paciente_id = Paciente.id)                    
                    -- group by Protocolo.id
        ";
                 
           if (isset($params['ProtocoloSearch']['nro_secuencia']) && ($params['ProtocoloSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['ProtocoloSearch']['nro_secuencia'];
        
        if (isset($params['ProtocoloSearch']['nombre']) && ($params['ProtocoloSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '%".$params['ProtocoloSearch']['nombre']."%'";
        
       
        if (isset($params['ProtocoloSearch']['nro_documento']) && ($params['ProtocoloSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['ProtocoloSearch']['nro_documento']."%'";
          
        
        if (isset($params['ProtocoloSearch']['codigo']) && ($params['ProtocoloSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['ProtocoloSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
            }

         if(isset($params['ProtocoloSearch']['fecha_entrada']) && ($params['ProtocoloSearch']['fecha_entrada'] <> "")) 
            { 
                list($start_date, $end_date) = explode(' - ', $params['ProtocoloSearch']['fecha_entrada']); 
       
                $dia = substr($start_date,0,2);
                $mes = substr($start_date,3,2);
                $anio = substr($start_date,6,4);
                $time = $anio."-".$mes."-".$dia;

                $dia2 = substr($end_date,0,2);
                $mes2 = substr($end_date,3,2);
                $anio2 = substr($end_date,6,4);
                $time2 = $anio2."-".$mes2."-".$dia2;
                $query = $query." and  Protocolo.fecha_entrada between '".$time."' and '".$time2."'";
            } 
        
        if(isset($params['ProtocoloSearch']['fecha_entrega']) && ($params['ProtocoloSearch']['fecha_entrega'] <> "")) 
            { 
                list($start_date, $end_date) = explode(' - ', $params['ProtocoloSearch']['fecha_entrega']); 
       
                $dia = substr($start_date,0,2);
                $mes = substr($start_date,3,2);
                $anio = substr($start_date,6,4);
                $time = $anio."-".$mes."-".$dia;

                $dia2 = substr($end_date,0,2);
                $mes2 = substr($end_date,3,2);
                $anio2 = substr($end_date,6,4);
                $time2 = $anio2."-".$mes2."-".$dia2;
                $query = $query." and  Protocolo.fecha_entrega between '".$time."' and '".$time2."'";
            } 
 
        $consultaCant = 'SELECT count(tt.id) as total FROM ('.$query.') as tt';

        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];  

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'sort' => [
                 'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                     'nombre',
                    'nro_documento' => [
                        'asc' => ['Paciente.nro_documento' => SORT_ASC],
                        'desc' => ['Paciente.nro_documento' => SORT_DESC],
                    ],
                    'id' => [
                        'asc' => [new Expression('id')],
                        'desc' => [new Expression('id DESC ')],
                        'default' => SORT_DESC,
                    ],             
                ],
            ],
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 100,
            ],
        ]);
 
        return $dataProvider;
    }
    
  
    
    protected function addSearchParameter($query, $attribute, $partialMatch = true)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }
 
        $value = $this->$modelAttribute;
        
        if (trim($value) === '') {
            return;
        }
        $attribute = "Protocolo.$attribute";

    }
    

    public function search_pendientes($params)
    {
        $consulta = "Select
                        Protocolo.id,
                        Protocolo.anio,
                        Protocolo.letra,
                        Protocolo.nro_secuencia,
                        Workflow_Q.Informe_id,
                        Workflow_Q.fecha_inicio,
                        Workflow_Q.workflow_id,
                        Workflow_Q.Estado_id
                    From Protocolo
                    JOIN Informe ON (Protocolo.id = Informe.Protocolo_id)
                    JOIN (
                            Select
                                    Workflow.Informe_id,
                                    max(Workflow.fecha_inicio) as fecha_inicio,
                                    max(Workflow.id) as workflow_id,
                                    Workflow.Estado_id
                            From Workflow 
                            WHERE Workflow.Estado_id = 4
                            GROUP BY Workflow.Informe_id
                    ) as Workflow_Q ON (Informe.id = Workflow_Q.Informe_id);";
        
        $consultaCant = "Select
                        count(Protocolo.id) as total                        
                    From Protocolo
                    JOIN Informe ON (Protocolo.id = Informe.Protocolo_id)
                    JOIN (
                            Select
                                    Workflow.Informe_id,
                                    max(Workflow.fecha_inicio) as fecha_inicio,
                                    max(Workflow.id) as workflow_id,
                                    Workflow.Estado_id
                            From Workflow 
                            WHERE Workflow.Estado_id = 4
                            GROUP BY Workflow.Informe_id
                    ) as Workflow_Q ON (Informe.id = Workflow_Q.Informe_id);";
        
        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];  

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $consulta,
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
     
        return $dataProvider;
    }
    


 /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    
     public function search_terminados($params)
    {     
       
        $queryParams = [];
        $where = 'Workflow.Estado_id = 5';
        $formParams = [];
        if(array_key_exists('ProtocoloSearch',$params)) {
            $formParams = $params['ProtocoloSearch'];
        }

        $fieldList = '
                        Protocolo.id,    
                        Protocolo.codigo,
                        Protocolo.fecha_entrada,
                        Protocolo.fecha_entrega,
                        Protocolo.letra,
                        Protocolo.nro_secuencia,
                        Paciente.nro_documento,                        
                        Workflow.fecha_inicio,
                        Workflow.id AS workflow_id,
                        Informe.id as informe_id,
                        Informe.Estudio_id,
                        Paciente.nombre as nombre,
                        Estudio.nombre as nombre_estudio,
                        Workflow.Estado_id,
                        CONCAT(UCASE(LEFT(u.username, 1)),SUBSTRING(u.username, 2)) as ultimo_propietario				
        ';
        $fromTables = '
                Protocolo
                JOIN          Informe                   ON (Protocolo.id = Informe.Protocolo_id)
                LEFT JOIN     Paciente_prestadora       ON Protocolo.Paciente_prestadora_id = Paciente_prestadora.id
                LEFT JOIN     Paciente                  ON Paciente_prestadora.Paciente_id = Paciente.id
                JOIN          view_informe_ult_workflow ON Informe.id = view_informe_ult_workflow.Informe_id
                LEFT JOIN     Workflow                  ON view_informe_ult_workflow.id = Workflow.id
				JOIN          Estudio                   ON (Informe.Estudio_id = Estudio.id)
                JOIN          user u                    ON(Workflow.Responsable_id=u.id)
        ';

        $this->nombreFilter($formParams, $where, $queryParams);
        
        $this->nroDocumentoFilter($formParams, $where, $queryParams);

        $this->fechaEntradaFilter($formParams, $where, $queryParams);
         
        $this->codigoFilter($formParams, $where, $queryParams);

        $this->fechaEntregaFilter($formParams, $where, $queryParams);

        $this->propietarioFilter($formParams, $where, $queryParams);

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
                'defaultOrder' => ['fecha_entrada' => SORT_DESC],
                'attributes' => [
                     'nombre',
                     'fecha_entrada',
                     'fecha_entrega',
                     'codigo',
                     'ultimo_propietario',                     
                    'nro_documento' => [
                        'asc' => ['Paciente.nro_documento' => SORT_ASC],
                        'desc' => ['Paciente.nro_documento' => SORT_DESC],
                    ],
                    'id' => [
                        'asc' => [new Expression('id')],
                        'desc' => [new Expression('id DESC ')],
                        'default' => SORT_DESC,
                    ],
                    
                    
                ],
            ],
            'totalCount' => $itemsCount,
            'key'        => 'id' ,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
                return $dataProvider;
            }

        return $dataProvider;
    }



  

      public function search_asignados($id=null, $params=NULL)
    {
        if (isset($id))
            $loggedUserId = $id;
        else $loggedUserId = 2;
    
        $consulta = "
                    Select 
                        Protocolo.codigo, 
                        Protocolo.id,
                        Workflow.Informe_id as informe_id,
                        Workflow.fecha_inicio,
                        Protocolo.fecha_entrada,
                        Protocolo.fecha_entrega,
                        Protocolo.nro_secuencia,
                        Protocolo.anio,Protocolo.letra,
                        Workflow.id as workflow_id,
                        Workflow.Estado_id,
                        Informe.Estudio_id as estudio,
                        Paciente.nombre as nombre,
                        Workflow.Estado_id as lastEstado,
                        Paciente.nro_documento,
                        Estudio.nombre as nombre_estudio
                    From Protocolo
                    JOIN Informe ON (Protocolo.id = Informe.Protocolo_id)
                    JOIN Estudio ON (Informe.Estudio_id = Estudio.id)
                    JOIN Paciente_prestadora ON (Protocolo.Paciente_prestadora_id = Paciente_prestadora.id)
                    JOIN Paciente ON (Paciente_prestadora.Paciente_id = Paciente.id)
					JOIN view_informe_ult_workflow ON (Informe.id = view_informe_ult_workflow.Informe_id)
					JOIn Workflow on view_informe_ult_workflow.id = Workflow.id 
					WHERE Workflow.Estado_id >=3 and Workflow.Estado_id <=4      
                    AND Workflow.Responsable_id = ".$loggedUserId;
        
        if (isset($params['ProtocoloSearch']['codigo']) && ($params['ProtocoloSearch']['codigo'] <> "") )
            $consulta = $consulta." and Protocolo.codigo like '%".$params['ProtocoloSearch']['codigo']."%'";
        
        if (isset($params['ProtocoloSearch']['nombre']) && ($params['ProtocoloSearch']['nombre'] <> "") )
            $consulta = $consulta." and Paciente.nombre like '%".$params['ProtocoloSearch']['nombre']."%'";
        
        if (isset($params['ProtocoloSearch']['nro_documento']) && ($params['ProtocoloSearch']['nro_documento'] <> "") )
            $consulta = $consulta." and Paciente.nro_documento like '%".$params['ProtocoloSearch']['nro_documento']."%'";
        
       if(isset($params['ProtocoloSearch']['fecha_entrada']) && ($params['ProtocoloSearch']['fecha_entrada'] <> "")) 
            { 
                list($start_date, $end_date) = explode(' - ', $params['ProtocoloSearch']['fecha_entrada']); 
       
                $dia = substr($start_date,0,2);
                $mes = substr($start_date,3,2);
                $anio = substr($start_date,6,4);
                $time = $anio."-".$mes."-".$dia;
                $dia2 = substr($end_date,0,2);
                $mes2 = substr($end_date,3,2);
                $anio2 = substr($end_date,6,4);
                $time2 = $anio2."-".$mes2."-".$dia2;
                $consulta = $consulta." and  Protocolo.fecha_entrada between '".$time."' and '".$time2."'";
            } 
        
        if(isset($params['ProtocoloSearch']['fecha_entrega']) && ($params['ProtocoloSearch']['fecha_entrega'] <> "")) 
            { 
                list($start_date, $end_date) = explode(' - ', $params['ProtocoloSearch']['fecha_entrega']); 
       
                $dia = substr($start_date,0,2);
                $mes = substr($start_date,3,2);
                $anio = substr($start_date,6,4);
                $time = $anio."-".$mes."-".$dia;
                $dia2 = substr($end_date,0,2);
                $mes2 = substr($end_date,3,2);
                $anio2 = substr($end_date,6,4);
                $time2 = $anio2."-".$mes2."-".$dia2;
                $consulta = $consulta." and  Protocolo.fecha_entrega between '".$time."' and '".$time2."'";
            }   

       
        $consultaCant = "select count(tt.id) as total from ( ".$consulta." ) as tt";
        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];       
        $dataProvider_asignados = new \yii\data\SqlDataProvider([
            'sql' => $consulta,
            'sort'=> ['defaultOrder' => ['fecha_entrada' => SORT_DESC]],
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
        $dataProvider_asignados->setSort([
            'defaultOrder' => ['fecha_entrada' => SORT_DESC],
            'attributes' => [
                'fecha_entrega',
                'codigo',
                'fecha_entrega',
                'fecha_entrada',
                'codigo',
                'nombre'=> [
                    'asc' => ['Paciente.nombre' => SORT_ASC],
                    'desc' => ['Paciente.nombre' => SORT_DESC],
                ],
                'nro_documento' => [
                    'asc' => ['Paciente.nro_documento' => SORT_ASC],
                    'desc' => ['Paciente.nro_documento' => SORT_DESC],
                ]
            ]
        ]);
        if (!($this->load($params) && $this->validate())) {
                return $dataProvider_asignados;
            }
        return $dataProvider_asignados;
    }

       
     public function search_entregados($params)
    {     
       
        $queryParams = [];
        $where = 'Workflow.Estado_id = 6';
        $formParams = [];
        if(array_key_exists('ProtocoloSearch',$params)) {
            $formParams = $params['ProtocoloSearch'];
        }

        $fieldList = '
                Protocolo.id,    
                Protocolo.codigo,
                Protocolo.fecha_entrada,
                Protocolo.fecha_entrega,
                Protocolo.letra,
                Protocolo.nro_secuencia,
                Paciente.nro_documento,                        
                Workflow.fecha_inicio,
                Workflow.id AS workflow_id,
                Informe.id as informe_id,
                Informe.Estudio_id,
                Paciente.nombre as nombre,
                Estudio.nombre as nombre_estudio,
                Workflow.Estado_id,
                CONCAT(UCASE(LEFT(u.username, 1)),SUBSTRING(u.username, 2)) as ultimo_propietario		
        ';
        $fromTables = '
                Protocolo
                JOIN        Informe                     ON (Protocolo.id = Informe.Protocolo_id)
                LEFT JOIN   Paciente_prestadora         ON Protocolo.Paciente_prestadora_id = Paciente_prestadora.id
                LEFT JOIN   Paciente                    ON Paciente_prestadora.Paciente_id = Paciente.id
                JOIN        view_informe_ult_workflow   ON Informe.id = view_informe_ult_workflow.Informe_id
                LEFT JOIN   Workflow                    ON view_informe_ult_workflow.id = Workflow.id
				JOIN        Estudio                     ON (Informe.Estudio_id = Estudio.id)
                JOIN        user u                      ON(Workflow.Responsable_id=u.id)
        ';
     		
                                        
       $this->propietarioFilter($formParams, $where, $queryParams);	

        $this->nombreFilter($formParams, $where, $queryParams);
        
        $this->nroDocumentoFilter($formParams, $where, $queryParams);

        $this->fechaEntradaFilter($formParams, $where, $queryParams);
         
        $this->codigoFilter($formParams, $where, $queryParams);

        $this->fechaEntregaFilter($formParams, $where, $queryParams);

        

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
                'defaultOrder' => ['fecha_entrada' => SORT_DESC],
                'attributes' => [
                     'nombre',
                     'fecha_entrada',
                     'fecha_entrega',
                     'codigo',
                     
                    'nro_documento' => [
                        'asc' => ['Paciente.nro_documento' => SORT_ASC],
                        'desc' => ['Paciente.nro_documento' => SORT_DESC],
                    ],
                    'ultimo_propietario',
                    'id' => [
                        'asc' => [new Expression('id')],
                        'desc' => [new Expression('id DESC ')],
                        'default' => SORT_DESC,
                    ],
                    
                    
                ],
            ],
            'totalCount' => $itemsCount,
            'key'        => 'id' ,
            'pagination' => [
                    'pageSize' => 50,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
                return $dataProvider;
            }

        return $dataProvider;
    }






    
    public function search_informes_contables($params)
    {
        
        $query = "Select concat(SUBSTRING(Protocolo.anio,-2),Protocolo.letra,'-', LPAD(Protocolo.nro_secuencia, 6, 0)) as codigo , 
                    Protocolo.* , 
                    Paciente.nombre as nombre,
                    Estudio.nombre as nombre_estudio,
                    Pago.nro_formulario,
                    Pago.fecha,
                    Pago.importe,
                    pr.id as Prestadoras_id
                    From Protocolo
                    JOIN Informe ON (Protocolo.id = Informe.Protocolo_id)
                     JOIN Prestadoras pr on Protocolo.FacturarA_id=pr.id
                    LEFT JOIN `Paciente_prestadora` pp ON `Protocolo`.`Paciente_prestadora_id` = pp.`id`
                    LEFT JOIN `Paciente` ON pp.`Paciente_id` = `Paciente`.`id`
                    JOIN Estudio ON (Informe.Estudio_id = Estudio.id)
                    JOIN Pago ON (Pago.id=Informe.Pago_id)
                    WHERE Informe.Pago_id IS NOT NULL 
                    
                    " ;
        
        if (isset($params['ProtocoloSearch']['nro_secuencia']) && ($params['ProtocoloSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['ProtocoloSearch']['nro_secuencia'];
        
        if (isset($params['ProtocoloSearch']['nombre']) && ($params['ProtocoloSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '%".$params['ProtocoloSearch']['nombre']."%'";
        
       
        if (isset($params['ProtocoloSearch']['nro_documento']) && ($params['ProtocoloSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['ProtocoloSearch']['nro_documento']."%'";
          
        if (isset($params['ProtocoloSearch']['fecha_entrega']) && ($params['ProtocoloSearch']['fecha_entrega'] <> "") ){
            $str =  $params['ProtocoloSearch']['fecha_entrega']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrega like '".$time."%'";
        }
        
        if (isset($params['ProtocoloSearch']['fecha_entrada']) && ($params['ProtocoloSearch']['fecha_entrada'] <> "") ){
            $str =  $params['ProtocoloSearch']['fecha_entrada']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrada like '".$time."%'";
        }
        
        if (isset($params['ProtocoloSearch']['codigo']) && ($params['ProtocoloSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['ProtocoloSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
               // die($query);
            }
        if (isset($params['ProtocoloSearch']['Prestadoras_id'])  ){
              $query = $query." and Protocolo.FacturarA_id=".$params['ProtocoloSearch']['Prestadoras_id'];
         }  
        $consultaCant = "Select
                        count(tt.codigo) as total from (";
        
        $consultaCant = $consultaCant.$query." ) as tt";
        
        $order = " ORDER BY Pago.fecha DESC;";
        $query = $query.$order;
        
        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];  

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 20,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
     
        return $dataProvider;
    }
    
    
    public function search_informes_impagos($params)
    {
        
        $query = "Select concat(SUBSTRING(Protocolo.anio,-2),Protocolo.letra,'-', LPAD(Protocolo.nro_secuencia, 6, 0)) as codigo , 
                    Protocolo.* , 
                    Paciente.nombre as nombre,
                    Estudio.nombre as nombre_estudio,
                    Informe.estado_actual,
                    pr.id as Prestadoras_id
                    From Protocolo
                    JOIN Informe ON (Protocolo.id = Informe.Protocolo_id)
                    LEFT JOIN `Paciente_prestadora` pp ON `Protocolo`.`Paciente_prestadora_id` = pp.`id`
                    JOIN Prestadoras pr on Protocolo.FacturarA_id=pr.id
                    LEFT JOIN `Paciente` ON pp.`Paciente_id` = `Paciente`.`id`
                    JOIN Estudio ON (Informe.Estudio_id = Estudio.id)
                    WHERE Informe.Pago_id IS NULL 
                    
                    " ;
        
        if (isset($params['ProtocoloSearch']['nro_secuencia']) && ($params['ProtocoloSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['ProtocoloSearch']['nro_secuencia'];
        
        if (isset($params['ProtocoloSearch']['nombre']) && ($params['ProtocoloSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '%".$params['ProtocoloSearch']['nombre']."%'";
        
       
        if (isset($params['ProtocoloSearch']['nro_documento']) && ($params['ProtocoloSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['ProtocoloSearch']['nro_documento']."%'";
          
        if (isset($params['ProtocoloSearch']['fecha_entrega']) && ($params['ProtocoloSearch']['fecha_entrega'] <> "") ){
            $str =  $params['ProtocoloSearch']['fecha_entrega']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrega like '".$time."%'";
        }
        
        if (isset($params['ProtocoloSearch']['fecha_entrada']) && ($params['ProtocoloSearch']['fecha_entrada'] <> "") ){
            $str =  $params['ProtocoloSearch']['fecha_entrada']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrada like '".$time."%'";
        }
        
        if (isset($params['ProtocoloSearch']['codigo']) && ($params['ProtocoloSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['ProtocoloSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
               // die($query);
            }
                  
         if (isset($params['ProtocoloSearch']['Prestadoras_id'])  ){
               $query = $query." and Protocolo.FacturarA_id =".$params['ProtocoloSearch']['Prestadoras_id'];
         }
        
        $consultaCant = "Select
                        count(tt.codigo) as total from (";
        
        $consultaCant = $consultaCant.$query." ) as tt";
        
        $order = " ORDER BY Protocolo.fecha_entrada DESC;";
        $query = $query.$order;
        
        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];  

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 20,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
     
        return $dataProvider;
    }
   
    public function search_facturables($params,$prestadora=null,$fechaHasta=null,$fechaDesde=null)
    {
        $query=null;

        $prestadora_default=  Prestadoras::getPaticular();
         
                    $query = "Select  concat(SUBSTRING(Protocolo.anio,-2),Protocolo.letra,'-', LPAD(Protocolo.nro_secuencia, 6, 0)) as codigo , 
                        Protocolo.* , 
                        Paciente.nro_documento,                        
                        Paciente.nombre as nombre, pr.descripcion as nombre_prestadora,
                        pr.id as Prestadoras_id,
                        pr.id as Prestadora
                        From Protocolo
                        LEFT JOIN `Paciente_prestadora` pp ON `Protocolo`.`Paciente_prestadora_id` = pp.`id`
                        LEFT JOIN `Paciente` ON pp.`Paciente_id` = `Paciente`.`id`
			LEFT JOIN  Prestadoras pr  ON   pr.`id` =Protocolo.FacturarA_id
                        WHERE  Protocolo.id in (
                                                 select Protocolo_id as id 
                                                 from Informe
                                                 where Pago_id is  null and Protocolo_id = Protocolo.id
                                                ) " ;
         
         if($prestadora!=null and ($fechaHasta!="") and ($fechaDesde==="") ){
              $query = $query." and pr.id =".$prestadora. " AND Protocolo.fecha_entrada<= '".$fechaHasta."'" ;  
         
         }
         else if($prestadora!=null and ($fechaHasta==="") and ($fechaDesde!="") ){
              $query = $query." and pr.id =".$prestadora. " AND Protocolo.fecha_entrada>= '". $fechaDesde ."'";   
         }
         else if($prestadora!=null and $fechaHasta!="" and $fechaDesde!="" ){
                $query = $query." and pr.id =".$prestadora. " AND Protocolo.fecha_entrada between'".$fechaDesde."'  AND  '".$fechaHasta ."'"; 
         }
         else if($prestadora!=null and $fechaHasta==="" and $fechaDesde=="" ){
              $query = $query." and pr.id =".$prestadora ; 
         }
         else{
             $query = $query." and pr.id =0";
         }     
//         var_dump($prestadora);    var_dump($fechaHasta);    var_dump($fechaDesde);    var_dump($query); die();
        if (isset($params['ProtocoloSearch']['nro_secuencia']) && ($params['ProtocoloSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['ProtocoloSearch']['nro_secuencia'];
        
        if (isset($params['ProtocoloSearch']['nombre']) && ($params['ProtocoloSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '".$params['ProtocoloSearch']['nombre']."%'";
        
       
        if (isset($params['ProtocoloSearch']['nro_documento']) && ($params['ProtocoloSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['ProtocoloSearch']['nro_documento']."%'";
          
        if (isset($params['ProtocoloSearch']['fecha_entrega']) && ($params['ProtocoloSearch']['fecha_entrega'] <> "") ){
            $str =  $params['ProtocoloSearch']['fecha_entrega']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrega like '".$time."%'";
        }
        
        if (isset($params['ProtocoloSearch']['fecha_entrada']) && ($params['ProtocoloSearch']['fecha_entrada'] <> "") ){
            $str =  $params['ProtocoloSearch']['fecha_entrada']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrada like '".$time."%'";
        }
        
        if (isset($params['ProtocoloSearch']['codigo']) && ($params['ProtocoloSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['ProtocoloSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
               // die($query);
            }
            
   
        
        $consultaCant = "Select
                        count(tt.codigo) as total from (";
        
        $consultaCant = $consultaCant.$query." ) as tt";
        
        $order = " order by Protocolo.id desc;";
        $query = $query.$order;
        
        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];  

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $query,
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 20,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
     
        return $dataProvider;
    }

    public function search_asignados_index($id=null, $params=NULL)
    {
        if (isset($id))
            $loggedUserId = $id;
        else $loggedUserId = 2;
    
        $consulta = "
            Select 
                Protocolo.codigo,
                Protocolo.id,
                Workflow.Informe_id as informe_id,
                Workflow.fecha_inicio,
                Protocolo.fecha_entrada,
                Protocolo.fecha_entrega,
                Protocolo.nro_secuencia,
                Protocolo.anio,Protocolo.letra,
                Workflow.id workflow_id,
                Workflow.Estado_id,
                Informe.Estudio_id as estudio,
                Paciente.nombre as nombre,
                Workflow.Estado_id as lastEstado,
                Paciente.nro_documento,
                Estudio.nombre as nombre_estudio
            From Protocolo
            JOIN Informe ON (Protocolo.id = Informe.Protocolo_id)
            JOIN Estudio ON (Informe.Estudio_id = Estudio.id)
            JOIN Paciente_prestadora ON (Protocolo.Paciente_prestadora_id = Paciente_prestadora.id)
            JOIN Paciente ON (Paciente_prestadora.Paciente_id = Paciente.id)
            JOIN view_informe_ult_workflow ON (view_informe_ult_workflow.informe_id = Informe.id)
            JOIN Workflow ON (view_informe_ult_workflow.id = Workflow.id)
            WHERE
            Workflow.Estado_id <  5 
            AND Workflow.Responsable_id = ".$loggedUserId."        
        ";
                //    order by Protocolo.id desc;";
        
        if (isset($params['ProtocoloSearch']['nro_secuencia']) && ($params['ProtocoloSearch']['nro_secuencia'] <> "") )
            $consulta = $consulta." and Protocolo.nro_secuencia = ".$params['ProtocoloSearch']['nro_secuencia'];
        
        if (isset($params['ProtocoloSearch']['nombre']) && ($params['ProtocoloSearch']['nombre'] <> "") )
            $consulta = $consulta." and Paciente.nombre like '%".$params['ProtocoloSearch']['nombre']."%'";
        
        if (isset($params['ProtocoloSearch']['nro_documento']) && ($params['ProtocoloSearch']['nro_documento'] <> "") )
            $consulta = $consulta." and Paciente.nro_documento like '%".$params['ProtocoloSearch']['nro_documento']."%'";
        
        if(isset($params['ProtocoloSearch']['fecha_entrada']) && ($params['ProtocoloSearch']['fecha_entrada'] <> "")) 
            { 
                list($start_date, $end_date) = explode(' - ', $params['ProtocoloSearch']['fecha_entrada']); 
       
                $dia = substr($start_date,0,2);
                $mes = substr($start_date,3,2);
                $anio = substr($start_date,6,4);
                $time = $anio."-".$mes."-".$dia;

                $dia2 = substr($end_date,0,2);
                $mes2 = substr($end_date,3,2);
                $anio2 = substr($end_date,6,4);
                $time2 = $anio2."-".$mes2."-".$dia2;
                $consulta = $consulta." and  Protocolo.fecha_entrada between '".$time."' and '".$time2."'";
            } 
        
        if(isset($params['ProtocoloSearch']['fecha_entrega']) && ($params['ProtocoloSearch']['fecha_entrega'] <> "")) 
            { 
                list($start_date, $end_date) = explode(' - ', $params['ProtocoloSearch']['fecha_entrega']); 
       
                $dia = substr($start_date,0,2);
                $mes = substr($start_date,3,2);
                $anio = substr($start_date,6,4);
                $time = $anio."-".$mes."-".$dia;

                $dia2 = substr($end_date,0,2);
                $mes2 = substr($end_date,3,2);
                $anio2 = substr($end_date,6,4);
                $time2 = $anio2."-".$mes2."-".$dia2;
                $consulta = $consulta." and  Protocolo.fecha_entrega between '".$time."' and '".$time2."'";
            }   
        if (isset($params['ProtocoloSearch']['codigo']) && ($params['ProtocoloSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['ProtocoloSearch']['codigo'], '0');
                $consulta = $consulta." and (Protocolo.anio like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['ProtocoloSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
               // die($query);
            }
            
       
        $consultaCant = "select count(tt.id) as total from ( ".$consulta." ) as tt";

        $command =  \Yii::$app->db->createCommand($consultaCant);
        $results = $command->queryAll();
        $itemsCount = (int)$results[0]["total"];       

        $dataProvider_asignados = new \yii\data\SqlDataProvider([
            'sql' => $consulta,
            'sort'=> ['defaultOrder' => ['fecha_entrega'=> SORT_DESC]],
            'totalCount' => $itemsCount,
            'pagination' => [
                    'pageSize' => 5,
            ],
        ]);

        $dataProvider_asignados->setSort([
            'defaultOrder' => ['fecha_entrada' => SORT_DESC],
            'attributes' => [
                'fecha_entrega',
                'nombre',
                'nro_documento'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
                return $dataProvider_asignados;
            }
        return $dataProvider_asignados;
    }
    

}

