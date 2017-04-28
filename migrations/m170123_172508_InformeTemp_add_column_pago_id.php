<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170123_172508_InformeTemp_add_column_pago_id extends Migration
{
    public function safeUp()
    {
        $this->addColumn("InformeTemp", "Pago_id",$this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn("InformeTemp", "Pago_id");
    }
}
