<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161020_135348_create_table_Leyenda extends Migration
{
	public function safeUp()
	{
		$this->createTable('Leyenda', [
				'id' => $this->primaryKey(),
				'codigo' => $this->integer('10'),
				'texto' =>  $this->string('50'),
				'categoria' =>  $this->string('10'),
			
		]);
	}
	
	public function safeDown()
	{
		$this->dropTable('Leyenda');
	}
}
