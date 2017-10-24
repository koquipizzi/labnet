<?php

use yii\db\Migration;

class m171024_132645_Paciente_alter_column_email_resize_longitud extends Migration
{
    public function safeUp()
    {
            $this->alterColumn('Paciente', 'email', $this->string(200));
    }

    public function safeDown()
    {
       
          $this->alterColumn('Paciente', 'email', $this->string(45));
    }
}
