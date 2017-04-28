<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161207_204916_agregar_titulo_tabla_informe extends Migration
{
	public function safeUp()
	{
		$this->addColumn('Informe','titulo', $this->string('255'));
	}
	
	public function safeDown()
	{
		$this->dropColumn('Informe','titulo');
	}
}
