<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161226_153433_Laboratorio_add_column_web_path_firma extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Laboratorio", 
                         "web_path_firma",
                        $this->string()->notNull()
                        );
    }

    public function safeDown()
    {
        $this->dropColumn("Laboratorio", "web_path_firma");
    }
}
