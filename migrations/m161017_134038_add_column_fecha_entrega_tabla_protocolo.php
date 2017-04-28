<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161017_134038_add_column_fecha_entrega_tabla_protocolo extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Protocolo', 'fecha_entrega', $this->date());
    }

    public function safeDown()
    {
        $this->dropColumn('Protocolo', 'fecha_entrega');
    }
}
