<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160926_133656_agregado_columna_notas_a_tabla_paciente extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Paciente', 'notas', Schema::TYPE_STRING . "(512) NULL");
    }

    public function safeDown()
    {
        $this->dropColumn('Paciente', 'notas');
    }
}
