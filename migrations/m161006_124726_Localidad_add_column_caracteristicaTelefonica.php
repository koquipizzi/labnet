<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161006_124726_Localidad_add_column_caracteristicaTelefonica extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Localidad', 'caracteristica_telefonica', $this->integer()->null());

    }

    public function safeDown()
    {
        $this->dropColumn('Localidad', 'caracteristica_telefonica');
    }
}
