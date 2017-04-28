<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161011_152241_add_column_edad_table_informe extends Migration
{
    public function safeUp()
    {
         $this->addColumn('Informe', 'edad', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('Informe', 'edad');
    }
}
