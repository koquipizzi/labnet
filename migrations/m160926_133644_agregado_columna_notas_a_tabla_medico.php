<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160926_133644_agregado_columna_notas_a_tabla_medico extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Medico', 'notas', Schema::TYPE_STRING . "(512) NULL");
    }

    public function safeDown()
    {
        $this->dropColumn('Medico', 'notas');
    }
}
