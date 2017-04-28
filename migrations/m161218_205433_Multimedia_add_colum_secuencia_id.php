<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161218_205433_Multimedia_add_colum_secuencia_id extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Multimedia",
                         "secuencia_id", $this->integer()
                );
    }

    public function safeDown()
    {
        $this->dropColumn("Multimedia", "secuencia_id");
    }
}
