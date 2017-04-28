<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161004_154543_addColumnInformacionAdicionalTableProcedencia extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Procedencia', 'informacion_adicional', Schema::TYPE_STRING . "(512) NULL");

    }

    public function safeDown()
    {
        $this->dropColumn('Procedencia', 'informacion_adicional');

    }
}
