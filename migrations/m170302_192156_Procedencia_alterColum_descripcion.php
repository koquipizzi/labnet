<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170302_192156_Procedencia_alterColum_descripcion extends Migration
{
    public function safeUp()
    {
       $this->dropColumn("Procedencia", "descipcion");
        $this->addColumn("Procedencia", "descripcion", $this->string("45"));
    }

    public function safeDown()
    {
       $this->dropColumn("Procedencia", "descripcion");
       $this->addColumn("Procedencia", "descripcion", $this->string("45"));
    }
}
