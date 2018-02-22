<?php

use yii\db\Migration;

class m180222_154815_Estado_add_column_Estado_final extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Estado","estado_final",$this->integer(1)->defaultValue("0"));
        $this->update("Estado",["estado_final"=>1],["descripcion"=>"Entregado"]);
    }

    public function safeDown()
    {
        $this->dropColumn("Estado","estado_final");  
    }
 
}
