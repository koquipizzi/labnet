<?php

use yii\db\Migration;

class m171024_130832_Medico_alter_column_email_resize_longitud extends Migration
{

  public function safeUp()
    {
            $this->alterColumn('Medico', 'email', $this->string(200));
    }

    public function safeDown()
    {
       
          $this->alterColumn('Medico', 'email', $this->string(45));
    }

}
