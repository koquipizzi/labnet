<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161122_191347_update_table_estado_tupla_entregado_column_autoAsignado extends Migration
{
	
		public function safeUp()
		{
			$this->update("Estado",['autoAsignado'=>'S'],["id"=>'6']);
		}
	
		public function safeDown()
		{
			$this->update("Estado",['autoAsignado'=>'N'],["id"=>'6']);
		}
}
