<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161212_223411_add_col_titulo_table_InformeTemp extends Migration
{
	public function safeUp()
	{
		$this->addColumn('InformeTemp','titulo', $this->string('255'));
                $this->addColumn('InformeTemp','tipo', $this->string('512'));
	}
	
	public function safeDown()
	{
		$this->dropColumn('InformeTemp','titulo');
                $this->dropColumn('InformeTemp','tipo');
	}
}
