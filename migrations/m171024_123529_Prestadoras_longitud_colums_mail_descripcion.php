<?php

use yii\db\Migration;

class m171024_123529_Prestadoras_longitud_colums_mail_descripcion extends Migration
{
    public function safeUp()
    {
            $this->alterColumn('Prestadoras', 'email', $this->string(200));
            $this->alterColumn('Prestadoras', 'descripcion', $this->string(200));
    }

    public function safeDown()
    {
       
          $this->alterColumn('Prestadoras', 'email', $this->string(45));
          $this->alterColumn('Prestadoras', 'descripcion', $this->string(45));
    }

}
