<?php

use yii\db\Migration;

class m171006_135715_Procedencia_inserts_descripcion extends Migration
{
    public function safeUp()
    {
        $this->update("Procedencia",['descripcion'=>'Hospital'],["id"=>'1']);
        $this->update("Procedencia",['descripcion'=>'Clínica'],["id"=>'2']);
        $this->update("Procedencia",['descripcion'=>'Otra Procedencia'],["id"=>'3']);
    }

    public function safeDown()
    {
        $this->update("Procedencia",['descripcion'=>''],["id"=>'1']);
        $this->update("Procedencia",['descripcion'=>''],["id"=>'2']);
        $this->update("Procedencia",['descripcion'=>''],["id"=>'3']);

    }

}
