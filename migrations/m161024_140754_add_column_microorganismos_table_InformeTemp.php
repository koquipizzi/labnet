<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161024_140754_add_column_microorganismos_table_InformeTemp extends Migration
{
	public function safeUp()
	{
			
		$this->addColumn('InformeTemp','microorganismos', $this->string('60'));
	
			
	}
	
	public function safeDown()
	{
		$this->dropColumn('InformeTemp','microorganismos');
	}
}
