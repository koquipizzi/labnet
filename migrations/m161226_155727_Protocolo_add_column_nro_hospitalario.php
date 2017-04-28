<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161226_155727_Protocolo_add_column_nro_hospitalario extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Protocolo", 
                         "numero_hospitalario",
                        $this->integer()
                        );
    }

    public function safeDown()
    {
        $this->dropColumn("Protocolo", "numero_hospitalario");
    }
}
