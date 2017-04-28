<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161018_141954_Paciente_update_fecha_nacimiento extends Migration
{
    public function safeUp()
    {

    	$this->update('Paciente',['fecha_nacimiento'=>'2000-02-12'],'nro_documento=255669455');
    	
    	$this->update('Paciente',['fecha_nacimiento'=>'2000-02-12'],'nro_documento=22334455');
    }

    public function safeDown()
    {
    	$this->update('Paciente',['fecha_nacimiento'=>''],'nro_documento=255669455');
    	 
    	$this->update('Paciente',['fecha_nacimiento'=>''],'nro_documento=22334455');
    	 
    }
}
