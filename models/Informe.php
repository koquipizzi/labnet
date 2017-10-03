<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
//use dosamigos\taggable\Taggable;
use sjaakp\taggable\TaggableBehavior;


/**
 * This is the model class for table "Informe".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $observaciones
 * @property string $material
 * @property string $tecnica
 * @property string $macroscopia
 * @property string $microscopia
 * @property string $diagnostico
 * @property string $Informecol
 * @property integer $Estudio_id
 * @property integer $Protocolo_id
 * @property integer $Pago_id
 * @property integer $edad
 * @property string $leucositos
 * @property string $aspecto
 * @property string $calidad
 * @property string $otros
 * @property string $flora
 * @property string $hematies
 * @property string $microorganismos
 * @property string $titulo
 * @property string $tipo
 * @property string $resultado
 * @property string $metodo
 * @property integer $estado_actual
 * @property Estudio $estudio
 * @property Protocolo $protocolo
 * @property Pago $pago
 * @property Workflow[] $workflows
 */
class Informe extends \yii\db\ActiveRecord
{
	
    public $files;
    public $editorTags;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Informe';
    }

   /* public function behaviors()
    {
     /*   return [
           
            'taggable' => [
                'class' => TaggableBehavior::className(),
                'tagClass' => Tag::className(),
                'junctionTable' => 'informe_tag_assn',
            ]
        ];*/
       /* return [
            'taggable' =>[
                'class' => TaggableBehavior::className(),
                'tagClass' => Tag::className(),
                'junctionTable' => 'informe_tag_assn',
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['editorTags'], 'safe'],
            [['Estudio_id', 'Protocolo_id'], 'required'],
            [['Estudio_id', 'Protocolo_id', 'edad', 'estado_actual'], 'integer'],
            [['descripcion', 'citologia'], 'string', 'max' => 2048],
            [['metodo', 'resultado'], 'string', 'max' => 2048],
            [['titulo'], 'isPap'],
            [['tipo'], 'string', 'max' => 512],
            [['descripcion','observaciones', 'material', 'tecnica', 'macroscopia', 'microscopia', 'diagnostico', 'leucositos','aspecto','calidad','otros','flora','hematies','aspecto','microorganismos',], 'string', 'max' => 2048],
            [['Informecol'], 'string', 'max' => 45],
            [['Estudio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estudio::className(), 'targetAttribute' => ['Estudio_id' => 'id']],
            [['Protocolo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Protocolo::className(), 'targetAttribute' => ['Protocolo_id' => 'id']],
            [['Pago_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pago::className(), 'targetAttribute' => ['Pago_id' => 'id']],
       ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'material' => Yii::t('app', 'Material'),
            'tecnica' => Yii::t('app', 'Técnica'),
            'macroscopia' => Yii::t('app', 'Macroscopia'),
            'microscopia' => Yii::t('app', 'Microscopia'),
            'diagnostico' => Yii::t('app', 'Diagnóstico'),
            'Informecol' => Yii::t('app', 'Informecol'),
            'Estudio_id' => Yii::t('app', 'Estudio ID'),
            'Protocolo_id' => Yii::t('app', 'Protocolo ID'),
            'leucositos' => Yii::t('app', 'Leucocitos'),
            'aspecto' => Yii::t('app', 'Aspecto'),
            'calidad' => Yii::t('app', 'Calidad de Muestra'),
            'otros' => Yii::t('app', 'Otros'),
            'flora' => Yii::t('app', 'Flora'),
            'hematies' => Yii::t('app', 'Hematíes'),
            'aspecto' => Yii::t('app', 'Aspecto'),
            'microorganismos' => Yii::t('app', 'Microorganismos'),
            'titulo' => Yii::t('app', 'Título'),
            'tipo' => Yii::t('app', 'Tipo de Estudio'),
            'citologia' => Yii::t('app', 'Citología Oncológica'),
            'metodo' => Yii::t('app', 'Método'),
            'resultado' => Yii::t('app', 'Resultado'),
        ];
    }
    
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

    /**
     * @author franco.a
     * Setea el campo tutulo con un valor por defecto,si el campo es null en algun momento tambien sera seteado a default
     * @param type $insert
     * @return boolean
     */   
    public function beforeSave($insert)
    {
     //   $component->attachBehaviors();
        if (parent::beforeSave($insert)) {
            if($this->Estudio_id==Estudio::getEstudioPap() && (strlen($this->titulo)<=1)){
                 $this->titulo = 'ESTUDIO DE CITOLOGIA EXFOLIATIVA (PAP)';
            }
             return true; 
        } else {
            return false;
        }
    }

   /**
    * @autor franco.a
    * validacion que verifica que el informe sea pap, de ser asi debe de tener seteado el atributo titulo ya que este es required 
    * @param type $attribute
    * @param type $params
    */
   public function isPap($attribute,$params){
        if($this->Estudio_id==Estudio::getEstudioPap() && (strlen($this->titulo)<=1) ){
            $this->addError($attribute, 'El titulo es requerido.');
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudio()
    {
        return $this->hasOne(Estudio::className(), ['id' => 'Estudio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProtocolo()
    {
        return $this->hasOne(Protocolo::className(), ['id' => 'Protocolo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflows()
    {
        return $this->hasMany(Workflow::className(), ['Informe_id' => 'id']);
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowLastState()
    {
        $ls =$this->hasOne(Workflow::className(), ['Informe_id' => 'id'])->orderBy('fecha_fin DESC')->one();
        $estado= $ls['Estado_id'];
        return $estado;
    }
    
    public function getCurrentWorkflow()
    {
        $ls =$this->hasOne(Workflow::className(), ['Informe_id' => 'id'])->orderBy('fecha_fin DESC')->one();
        $estado= $ls['id'];
        return $estado;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowLastStateName()
    {
        $ls =$this->hasOne(Workflow::className(), ['Informe_id' => 'id'])->orderBy('id DESC')->one();
        if (empty($ls))
            return "Pendiente";
        else 
            {
            $estado= $ls['Estado_id'];
            $descripcion= Estado::find()->andWhere("id =$estado")->one();
            return  $descripcion->attributes['descripcion'];
        }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getworkflowLastAsignationUser()
    {
    	$ls =$this->hasOne(Workflow::className(), ['Informe_id' => 'id'])->orderBy('id DESC')->one();
    	if (empty($ls))
            return "Pendiente";
        else {
                $usuario= $ls['Responsable_id'];
                $nombre= User::find()->andWhere("id =$usuario")->one();
                return  $nombre->attributes['username'];
        }
    
    }
    
    
    
    
    public function setWorkflowLastState()
    {
        $ls =$this->hasOne(Workflow::className(), ['Informe_id' => 'id'])->orderBy('id DESC')->one();
        return $ls['Estado_id'];    
    }

    /**
     * Obtiene los nomecladores relacionados
     *
     * @return string descripcion nomencladores
     */
    public function getNomencladores()
    {
        $nomencladores = "";
        $informeNomencladores = InformeNomenclador::find()
                ->andWhere("id_informe = $this->id");
//        var_dump($informeNomencladores);die();
        if (($informeNomencladores = InformeNomenclador::find()
                ->andWhere("id_informe = $this->id")
                ->asArray()->all()) !== null) {
            $informeNomencladores = ArrayHelper::getColumn($informeNomencladores, 'id_nomenclador');
            foreach ($informeNomencladores as $nomenclador){
                $r = Nomenclador::findOne(['id' => $nomenclador]);
               if(isset($r)){
                    $nomencladores .= $r->servicio;
                    $nomencladores .= ", ";
                }
                else{
                    $nomencladores .= "no tiene";
                    $nomencladores .= ", ";
                }
            }
        }
        if ( strlen ( $nomencladores ) === 0 )
            return $nomencladores;
        else if ( strlen ( $nomencladores ) < 40 )
            return substr($nomencladores, 0, -2);
    }
    
    public function getNomencladorInforme($id)
    {
        $nomencladores = "";
        return InformeNomenclador::find()
                ->andWhere("id = $id")
                ->asArray()->one();
        
        
        if (($informeNomenclador = InformeNomenclador::find()
                ->andWhere("id = $id")
                ->asArray()->all()) !== null) {
            return $informeNomenclador;
        }
        return NULL;
    }

    /**
     * @return informes del paciente
     */
    public function getHistorialUsuario()
    {
    	$protocolo =$this->getProtocolo();
    	$protocolo_id=$protocolo->primaryModel['Protocolo_id'];
    	$pacientePrestadora_id= Protocolo::find('Paciente_prestadora_id')->where("id=$protocolo_id")->one()['Paciente_prestadora_id'];
    	$paciente_id=PacientePrestadora::find()->where("id=$pacientePrestadora_id")->one()['Paciente_id'];
    	$idInforme=$this->id;
  //     $paciente_id= 37756;
        $informesPacientes= $this->findBySql("
    			select DISTINCT(i.id) AS 'id_informe', i.diagnostico ,
                i.descripcion, i.Estudio_id,  p.fecha_entrega
                from Informe i left JOIN Protocolo p ON(i.Protocolo_id=p.id)
                left JOIN Paciente_prestadora pc ON(p.Paciente_prestadora_id = pc.id)
                where (pc.Paciente_id=$paciente_id )
		    	order by p.fecha_entrega DESC
    			")->asArray()->all();

    	if (empty($informesPacientes))
    		return "No hay registrado ningún estudio perteneciente al paciente";
    	else
    		{
    			return $informesPacientes;
    		}
    
    }
    
    /**
     * @return nombre de un estudio
     */
    public function getNameEstudio($estudio_id)
    {
    	return Estudio::find()->where("id=$estudio_id")->one()['nombre'];
    }

    public function getValor($data)
    {
        switch($data) {
            case (string)0:
                return "-/++++";
                break;
            case (string)1:
                return "+/++++";
                break;
            case (string)2:
                return "++/++++";
                break;
            case (string)3:
                return "+++/++++";
                break;
            case (string)4:
                return "++++/++++";
                break;
            case "+":
                return "+/++++";
                break;
            case "++":
                return "++/++++";
                break;
            case "+++":
                return "+++/++++";
                break;
            case "++++":
                return "++++/++++";
                break;

        }
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('informe_tag_assn', ['informe_id' => 'id']);
    }
    
}
