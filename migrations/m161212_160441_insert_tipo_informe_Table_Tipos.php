<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161212_160441_insert_tipo_informe_Table_Tipos extends Migration
{
    public function safeUp()
    {
        $this->insert('Estudio', ['descripcion'=>'MOLECULAR', 'nombre'=>'MOLECULAR',  'titulo'=>'INFORME ANATOMOPATOLÓGICO']);
        $this->insert('Estudio', ['descripcion'=>'CITOLOGÍA ESPECIAL', 'nombre'=>'CITOLOGÍA ESPECIAL','titulo'=>'ESTUDIO DE CITOLOGÍA ESPECIAL']);    
    }

    public function safeDown()
    {   
        $this->delete('Estudio', ['nombre'=>'MOLECULAR']);
        $this->delete('Estudio', ['nombre'=>'CITOLOGÍA ESPECIAL']);
    }
}
