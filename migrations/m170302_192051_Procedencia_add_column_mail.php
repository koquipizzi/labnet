<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170302_192051_Procedencia_add_column_mail extends Migration
{
    public function safeUp()
    {  
        $this->addColumn("Procedencia", "mail", $this->string("45"));
    }

    public function safeDown()
    {
          $this->dropColumn("Procedencia", "mail");
    }
}
