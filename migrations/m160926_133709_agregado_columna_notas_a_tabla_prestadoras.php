<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160926_133709_agregado_columna_notas_a_tabla_prestadoras extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Prestadoras', 'notas', Schema::TYPE_STRING . "(512) NULL");
    }

    public function safeDown()
    {
        $this->dropColumn('Prestadoras', 'notas');
    }
}
