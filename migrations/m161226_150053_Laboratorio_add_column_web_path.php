<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161226_150053_Laboratorio_add_column_web_path extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Laboratorio", 
                         "web_path",
                        $this->string()->notNull()
                        );
    }

    public function safeDown()
    {
        $this->dropColumn("Laboratorio", "web_path");
    }
}
