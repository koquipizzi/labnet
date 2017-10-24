<?php

use yii\db\Migration;

class m171024_125601_Procedencia_alter_colums_email_descripcion_size extends Migration
{
  public function safeUp()
    {
            $this->alterColumn('Procedencia', 'mail', $this->string(200));
            $this->alterColumn('Procedencia', 'descripcion', $this->string(200));
    }

    public function safeDown()
    {
       
          $this->alterColumn('Procedencia', 'mail', $this->string(45));
          $this->alterColumn('Procedencia', 'descripcion', $this->string(45));
    }

}
