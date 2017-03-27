<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pago;

/**
 * PagoSearch represents the model behind the search form about `app\models\Pago`.
 */
class PagoSearch extends Pago
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'inporte', 'nro_formulario', 'Prestadoras_id'], 'integer'],
            [['fecha', 'observaciones'], 'safe'],
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
        $query = Pago::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'fecha' => $this->fecha,
            'inporte' => $this->inporte,
            'nro_formulario' => $this->nro_formulario,
            'Prestadoras_id' => $this->Prestadoras_id,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
    
    
    public function search_facturables($params)
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
                                                )  
                        
                    " ;
         if (isset($params['PagoSearch']['Prestadoras_id'])  ){
              $query = $query." and pr.id =".$params['PagoSearch']['Prestadoras_id'];
         }else{
             $query = $query." and pr.id =0";
         }     
                    
         
        if (isset($params['PagoSearch']['nro_secuencia']) && ($params['PagoSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['PagoSearch']['nro_secuencia'];
        
        if (isset($params['PagoSearch']['nombre']) && ($params['PagoSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '".$params['PagoSearch']['nombre']."%'";
        
       
        if (isset($params['PagoSearch']['nro_documento']) && ($params['PagoSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['PagoSearch']['nro_documento']."%'";
          
        if (isset($params['PagoSearch']['fecha_entrega']) && ($params['PagoSearch']['fecha_entrega'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrega']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrega like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['fecha_entrada']) && ($params['PagoSearch']['fecha_entrada'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrada']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrada like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['codigo']) && ($params['PagoSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['PagoSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['PagoSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['PagoSearch']['codigo']."%'"
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

    
    
     public function search_informes_de_un_Pago($params,$id_pago)
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
                    WHERE Informe.Pago_id=$id_pago
                    
                    " ;
        
        if (isset($params['PagoSearch']['nro_secuencia']) && ($params['PagoSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['PagoSearch']['nro_secuencia'];
        
        if (isset($params['PagoSearch']['nombre']) && ($params['PagoSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '".$params['PagoSearch']['nombre']."%'";
        
       
        if (isset($params['PagoSearch']['nro_documento']) && ($params['PagoSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['PagoSearch']['nro_documento']."%'";
          
        if (isset($params['PagoSearch']['fecha_entrega']) && ($params['PagoSearch']['fecha_entrega'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrega']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrega like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['fecha_entrada']) && ($params['PagoSearch']['fecha_entrada'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrada']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrada like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['codigo']) && ($params['PagoSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['PagoSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['PagoSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['PagoSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
               // die($query);
            }
                  
         if (isset($params['PagoSearch']['Prestadoras_id'])  ){
               $query = $query." and Protocolo.FacturarA_id =".$params['PagoSearch']['Prestadoras_id'];
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
        
        if (isset($params['PagoSearch']['nro_secuencia']) && ($params['PagoSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['PagoSearch']['nro_secuencia'];
        
        if (isset($params['PagoSearch']['nombre']) && ($params['PagoSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '".$params['PagoSearch']['nombre']."%'";
        
       
        if (isset($params['PagoSearch']['nro_documento']) && ($params['PagoSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['PagoSearch']['nro_documento']."%'";
          
        if (isset($params['PagoSearch']['fecha_entrega']) && ($params['PagoSearch']['fecha_entrega'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrega']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrega like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['fecha_entrada']) && ($params['PagoSearch']['fecha_entrada'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrada']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrada like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['codigo']) && ($params['PagoSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['PagoSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['PagoSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['PagoSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
               // die($query);
            }
        if (isset($params['PagoSearch']['Prestadoras_id'])  ){
              $query = $query." and Protocolo.FacturarA_id=".$params['PagoSearch']['Prestadoras_id'];
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
        
        if (isset($params['PagoSearch']['nro_secuencia']) && ($params['PagoSearch']['nro_secuencia'] <> "") )
            $query = $query." and Protocolo.nro_secuencia = ".$params['PagoSearch']['nro_secuencia'];
        
        if (isset($params['PagoSearch']['nombre']) && ($params['PagoSearch']['nombre'] <> "") )
            $query = $query." and Paciente.nombre like '".$params['PagoSearch']['nombre']."%'";
        
       
        if (isset($params['PagoSearch']['nro_documento']) && ($params['PagoSearch']['nro_documento'] <> "") )
            $query = $query." and Paciente.nro_documento like '%".$params['PagoSearch']['nro_documento']."%'";
          
        if (isset($params['PagoSearch']['fecha_entrega']) && ($params['PagoSearch']['fecha_entrega'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrega']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrega like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['fecha_entrada']) && ($params['PagoSearch']['fecha_entrada'] <> "") ){
            $str =  $params['PagoSearch']['fecha_entrada']; 
            $dia = substr($str,0,2);
            $mes = substr($str,3,2);
            $anio = substr($str,6,4);
            $time = $anio."-".$mes."-".$dia;
            $query = $query." and Protocolo.fecha_entrada like '".$time."%'";
        }
        
        if (isset($params['PagoSearch']['codigo']) && ($params['PagoSearch']['codigo'] <> "") )
            {
                $nro = ltrim($params['PagoSearch']['codigo'], '0');
                $query = $query." and (Protocolo.anio like '%".$params['PagoSearch']['codigo']."%'"
                    . "or Protocolo.letra like '%".$params['PagoSearch']['codigo']."%'"
                    . "or Protocolo.nro_secuencia like '%".$nro."%')";
               // die($query);
            }
                  
         if (isset($params['PagoSearch']['Prestadoras_id'])  ){
               $query = $query." and Protocolo.FacturarA_id =".$params['PagoSearch']['Prestadoras_id'];
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
    
    
    
    
    
    
    
    
}
