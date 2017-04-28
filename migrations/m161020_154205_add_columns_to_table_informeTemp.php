<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161020_154205_add_columns_to_table_informeTemp extends Migration
{
	public function safeUp()
	{
		 
		$this->addColumn('InformeTemp','leucositos', $this->string('10'));
		$this->addColumn('InformeTemp','aspecto', $this->string('10'));
		$this->addColumn('InformeTemp','calidad', $this->string('10'));
		$this->addColumn('InformeTemp','otros', $this->string('50'));
		$this->addColumn('InformeTemp','flora', $this->string('10'));
		$this->addColumn('InformeTemp','hematies', $this->string('10'));
		
		 
		 
	}
	
	public function safeDown()
	{
		$this->dropColumn('InformeTemp','leucositos');
		$this->dropColumn('InformeTemp','aspecto');
		$this->dropColumn('InformeTemp','calidad');
		$this->dropColumn('InformeTemp','otros');
		$this->dropColumn('InformeTemp','flora');
		$this->dropColumn('InformeTemp','hematies');
		
		 
		 
	}
}
