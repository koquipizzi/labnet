<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161024_140427_add_column_microorganismos_table_Informe extends Migration
{
	public function safeUp()
	{
			
		$this->addColumn('Informe','microorganismos', $this->string('60'));

			
	}
	
	public function safeDown()
	{
		$this->dropColumn('Informe','microorganismos');
	}
}
