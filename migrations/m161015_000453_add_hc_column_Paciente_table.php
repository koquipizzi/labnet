<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161015_000453_add_hc_column_Paciente_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Paciente', 'hc', $this->string(30)); //->notNull()->unique());
    }

    public function safeDown()
    {
         $this->dropColumn('Paciente', 'hc');
    }
}
