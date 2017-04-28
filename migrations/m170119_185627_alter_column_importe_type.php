<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170119_185627_alter_column_importe_type extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Pago", "importe",$this->double()->notNull());
        $this->dropColumn("Pago", "inporte");
    }

    public function safeDown()
    {
    }
}
