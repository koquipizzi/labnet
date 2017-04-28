<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161207_024048_create_table_multimedia extends Migration
{
    public function safeUp()
    {
    	$this->createTable("Multimedia",[
    					'id' => $this->primaryKey(),
    					'path' => $this->string('255'),
    					'webPath' =>  $this->string('255'),
    					'tipoMultimedia_id' =>  $this->integer('11')->notNull(),
		    			'objetos_id' =>  $this->integer('11')->notNull(),
		    			'descripcion' =>  $this->string('255'),
    			]);
    	}
    			
   	public function safeDown()
    	{
    		$this->dropTable('Multimedia');
    	}
}
