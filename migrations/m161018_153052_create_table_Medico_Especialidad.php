<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161018_153052_create_table_Medico_Especialidad extends Migration
{
	public function safeUp()
	{

		$this->createTable('Medico_especialidad', [
				'id' => $this->primaryKey(),
				'Medico_id' => $this->integer()->notNull(),
				'Especialidad_id' =>  $this->integer()->notNull(),
		]);

		
		$this->addForeignKey(
				'fk_Medico_especialidad_Especialidad',
				'Medico_especialidad',
				'Especialidad_id',
				'Especialidad',
				'id',
				'CASCADE'
				);
		
		// creates index for column `Especialidad_id`
		$this->createIndex(
				'idx-Medico_especialidad-Medico_id',
				'Medico_especialidad',
				'Medico_id'
				);
		
		$this->addForeignKey(
				'fk_Medico_especialidad_Medico',
				'Medico_especialidad',
				'Medico_id',
				'Medico',
				'id',
				'CASCADE'
				);
	}
	
	public function safeDown()
	{
		$this->dropTable('Medico_especialidad');
	}
}
