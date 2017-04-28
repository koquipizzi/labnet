<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161018_152501_create_table_Especialidad extends Migration
{
    public function safeUp()
    {
    	
    	$this->createTable('Especialidad', [
    			'id' => Schema::TYPE_PK,
    			'nombre' => Schema::TYPE_STRING . ' NOT NULL',
    			'descripcion' => Schema::TYPE_TEXT,
    	]);
    }

    public function safeDown()
    {
    	$this->dropTable('Especialidad');
    }
}
