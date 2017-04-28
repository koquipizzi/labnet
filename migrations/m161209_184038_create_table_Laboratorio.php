<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161209_184038_create_table_Laboratorio extends Migration
{
      public function safeUp()
    {
        $this->createTable('{{%Laboratorio}}', [
            'id' => Schema::TYPE_PK,
            'nombre' => Schema::TYPE_STRING . "(1024) NULL",
            'descripcion' => Schema::TYPE_STRING . "(255) NULL",
            'admin' => Schema::TYPE_STRING . "(255) NULL",
            'path_logo' => Schema::TYPE_STRING . "(255) NULL",
            'direccion' => Schema::TYPE_STRING . "(255) NULL",
            'web' => Schema::TYPE_STRING . "(255) NULL",
            'telefono' => Schema::TYPE_STRING . "(255) NULL",
            'mail' => Schema::TYPE_STRING . "(255) NULL",
            'info_mail' => Schema::TYPE_STRING . "(255) NULL",		    
        ], $this->tableOptions);    
        
    }
    

    public function safeDown()
    {
        $this->dropTable('Laboratorio');
        
    }
}
