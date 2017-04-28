<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161109_191051_add_column_estadoAutoAsignado_to_table_Estado extends Migration
{
	public function safeUp()
	{
		$this->addColumn('Estado','autoAsignado', $this->string('1'));
	}
	
	public function safeDown()
	{
		$this->dropColumn('Estado','autoAsignado');
	}
}
