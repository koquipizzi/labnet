<?php

use yii\db\Migration;

class m171031_203436_Medico_alter_resize_column_nombre extends Migration
{
    public function safeUp()
    {
            $this->alterColumn('Medico','nombre', $this->string('150'));
    }

    public function safeDown()
    {
        $this->alterColumn('Medico','nombre', $this->string('33'));
    }
}
