<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161222_155037_informeTemp_add_column_estado_actual extends Migration
{
    public function safeUp()
    {
        $this->addColumn("InformeTemp",
                         'estado_actual',
                          $this->integer()
                        );
    }

    public function safeDown()
    {
        $this->dropColumn('InformeTemp', 'estado_actual');
    }
}
