<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161228_154257_add_column_citologia_descripcion_table_Informe extends Migration
{
    public function safeUp()
    {
            $this->addColumn('Informe','citologia', $this->string('1024'));
    }

    public function safeDown()
    {
            $this->dropColumn('Informe','citologia');
    }
}
