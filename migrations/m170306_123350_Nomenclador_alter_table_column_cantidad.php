<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170306_123350_Nomenclador_alter_table_column_cantidad extends Migration
{
    public function safeUp()
    {
        $this->alterColumn("InformeNomenclador","cantidad", $this->integer()->defaultValue("1"));
    }

    public function safeDown()
    {
    }
}
