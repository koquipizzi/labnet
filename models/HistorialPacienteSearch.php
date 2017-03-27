<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistorialPaciente;

/**
 * HistorialPacienteSearch represents the model behind the search form about `app\models\HistorialPaciente`.
 */
class HistorialPacienteSearch extends HistorialPaciente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nro_secuencia', 'Medico_id', 'Procedencia_id', 'Paciente_prestadora_id', 'FacturarA_id', 'Estudio_id', 'Protocolo_id', 'edad', 'Tipo_documento_id', 'Localidad_id', 'Localidad_id_precedencia', 'Localidad_id_medico', 'especialidad_id'], 'integer'],
            [['fecha_entrada', 'anio', 'letra', 'registro', 'observaciones', 'fecha_entrega', 'descripcion', 'observaciones_informe', 'material', 'tecnica', 'macroscopia', 'microscopia', 'diagnostico', 'Informecol', 'leucositos', 'aspecto', 'calidad', 'otros', 'flora', 'hematies', 'microorganismos', 'titulo', 'tipo', 'nombre', 'nro_documento', 'sexo', 'fecha_nacimiento', 'telefono', 'email', 'domicilio', 'notas', 'hc', 'descipcion_procedencia', 'domicilio_procedencia', 'telefono_procedencia', 'informacion_adicional', 'nombre_medico', 'email_medico', 'domicilio_medico', 'telefono_medico', 'notas_medico'], 'safe'],
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
        $query = HistorialPaciente::find();

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
            'fecha_entrada' => $this->fecha_entrada,
            'nro_secuencia' => $this->nro_secuencia,
            'Medico_id' => $this->Medico_id,
            'Procedencia_id' => $this->Procedencia_id,
            'Paciente_prestadora_id' => $this->Paciente_prestadora_id,
            'FacturarA_id' => $this->FacturarA_id,
            'fecha_entrega' => $this->fecha_entrega,
            'Estudio_id' => $this->Estudio_id,
            'Protocolo_id' => $this->Protocolo_id,
            'edad' => $this->edad,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'Tipo_documento_id' => $this->Tipo_documento_id,
            'Localidad_id' => $this->Localidad_id,
            'Localidad_id_precedencia' => $this->Localidad_id_precedencia,
            'Localidad_id_medico' => $this->Localidad_id_medico,
            'especialidad_id' => $this->especialidad_id,
        ]);

        $query->andFilterWhere(['like', 'anio', $this->anio])
            ->andFilterWhere(['like', 'letra', $this->letra])
            ->andFilterWhere(['like', 'registro', $this->registro])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'observaciones_informe', $this->observaciones_informe])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'tecnica', $this->tecnica])
            ->andFilterWhere(['like', 'macroscopia', $this->macroscopia])
            ->andFilterWhere(['like', 'microscopia', $this->microscopia])
            ->andFilterWhere(['like', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['like', 'Informecol', $this->Informecol])
            ->andFilterWhere(['like', 'leucositos', $this->leucositos])
            ->andFilterWhere(['like', 'aspecto', $this->aspecto])
            ->andFilterWhere(['like', 'calidad', $this->calidad])
            ->andFilterWhere(['like', 'otros', $this->otros])
            ->andFilterWhere(['like', 'flora', $this->flora])
            ->andFilterWhere(['like', 'hematies', $this->hematies])
            ->andFilterWhere(['like', 'microorganismos', $this->microorganismos])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'nro_documento', $this->nro_documento])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio])
            ->andFilterWhere(['like', 'notas', $this->notas])
            ->andFilterWhere(['like', 'hc', $this->hc])
            ->andFilterWhere(['like', 'descipcion_procedencia', $this->descipcion_procedencia])
            ->andFilterWhere(['like', 'domicilio_procedencia', $this->domicilio_procedencia])
            ->andFilterWhere(['like', 'telefono_procedencia', $this->telefono_procedencia])
            ->andFilterWhere(['like', 'informacion_adicional', $this->informacion_adicional])
            ->andFilterWhere(['like', 'nombre_medico', $this->nombre_medico])
            ->andFilterWhere(['like', 'email_medico', $this->email_medico])
            ->andFilterWhere(['like', 'domicilio_medico', $this->domicilio_medico])
            ->andFilterWhere(['like', 'telefono_medico', $this->telefono_medico])
            ->andFilterWhere(['like', 'notas_medico', $this->notas_medico]);

        return $dataProvider;
    }
}
