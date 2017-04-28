<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161021_153520_Leyenda_alter_column_codigo extends Migration
{
    public function safeUp()
    {
    	$this->alterColumn('Leyenda', 'codigo',$this->string(10));
    }

    public function safeDown()
    {
    	
    }
}
