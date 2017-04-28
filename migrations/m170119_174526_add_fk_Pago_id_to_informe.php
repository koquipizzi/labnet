<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170119_174526_add_fk_Pago_id_to_informe extends Migration
{
    public function safeUp()
    {
       
        $this->addColumn("Informe","Pago_id", $this->integer());
        
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
        $this->dropForeignKey("fk_informe_pago", "Informe");
        $this->dropColumn("Informe", "Pago_id");
    }
}
