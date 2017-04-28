<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161115_184918_add_column_especialidadId_tabla_medico extends Migration
{
 public function safeUp()
    {
        $this->addColumn('Medico', 'especialidad_id', $this->integer());
        $this->dropColumn('Medico', 'especialidad');
    }

    public function safeDown()
    {
        $this->dropColumn('Medico', 'especialidad_id');
        $this->addColumn('Medico', 'especialidad', $this->integer());
    }
}
