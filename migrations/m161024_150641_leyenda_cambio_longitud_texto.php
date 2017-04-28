<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161024_150641_leyenda_cambio_longitud_texto extends Migration
{
    public function safeUp()
    {
    	$this->alterColumn('Leyenda', 'texto', $this->string('250'));
    }

    public function safeDown()
    {
    }
}
