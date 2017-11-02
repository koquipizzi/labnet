<?php

use yii\db\Migration;

class m171101_141229_Paciente_altercolumn_nombre_resize extends Migration
{
  public function safeUp()
    {
            $this->alterColumn('Paciente','nombre', $this->string(200));
    }

    public function safeDown()
    {
        $this->alterColumn('Paciente','nombre', $this->string(150));
    }

}
