<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161014_213358_add_edad_column_informeTemp_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('InformeTemp', 'edad', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('InformeTemp', 'edad');
    }
}
