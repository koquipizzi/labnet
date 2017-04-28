<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161205_225105_create_table_Nro_secuencia_protocolo extends Migration
{

	public function safeUp()
	{
	
		$this->createTable('Nro_secuencia_protocolo', [
				'id' => $this->primaryKey(),
				'fecha' => $this->date()->notNull(),
					
		]);
	
	}
	
	
	public function safeDown()
	{
		$this->dropTable('Nro_secuencia_protocolo');
	
	}
}
