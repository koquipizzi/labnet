<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170119_190357_informe_alter_fk extends Migration
{
    public function safeUp()
    {
       
          $this->dropForeignKey("fk_informe_pago", "Informe");
          $this->alterColumn("Informe","Pago_id", $this->integer()->null());
          $this->addForeignKey(
            'fk_informe_pago',
            'Informe',
            'Pago_id',
            'Pago',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
    }
}
