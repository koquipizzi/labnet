<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170228_221322_Laboratorio_add_columns_data__director extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Laboratorio", "director_nombre",     $this->string("50"));
        $this->addColumn("Laboratorio", "director_titulo",     $this->string("100"));
        $this->addColumn("Laboratorio", "director_matricula", $this->string("35"));
    }

    public function safeDown()
    {
        $this->dropColumn("Laboratorio", "director_nombre");
        $this->dropColumn("Laboratorio", "director_titulo");
        $this->dropColumn("Laboratorio", "director_matricula");
    }
}
