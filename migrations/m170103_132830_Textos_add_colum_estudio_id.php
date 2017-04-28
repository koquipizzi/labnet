<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170103_132830_Textos_add_colum_estudio_id extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Textos", "estudio_id", $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn("Textos", "estudio_id");
    }
}
