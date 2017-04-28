<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170228_233738_Medico_add_restriccion_length_nombre extends Migration
{
    public function safeUp()
    {
        $this->alterColumn("Medico", "nombre", $this->string("33"));
    }

    public function safeDown()
    {
    }
}
