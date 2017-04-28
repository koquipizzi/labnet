<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170222_192431_informe_pap_altertable_add_default extends Migration
{
    public function safeUp()
    {
         $this->alterColumn("Informe","hematies", $this->string("10")->defaultValue("0"));
         $this->alterColumn("Informe","leucositos", $this->string("10")->defaultValue("0"));
    }

    public function safeDown()
    {
         $this->alterColumn("Informe","hematies", $this->string("10"));
         $this->alterColumn("Informe","leucositos", $this->string("10"));
    }
}
