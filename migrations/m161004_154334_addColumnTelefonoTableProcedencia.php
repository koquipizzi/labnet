<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161004_154334_addColumnTelefonoTableProcedencia extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Procedencia', 'telefono', Schema::TYPE_STRING . "(20) NULL");

    }

    public function safeDown()
    {
        $this->dropColumn('Procedencia', 'telefono');
    }
}
