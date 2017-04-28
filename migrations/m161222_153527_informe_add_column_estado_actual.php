<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161222_153527_informe_add_column_estado_actual extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Informe",
                         'estado_actual',
                          $this->integer()
                        );
    }

    public function safeDown()
    {
        $this->dropColumn('Informe', 'estado_actual');
    }
}
