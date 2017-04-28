<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161202_201628_agregar_Leucocitos_a_tabla_Leyendas extends Migration
{
    public function safeUp()
    {
    	$this->insert('Leyenda', ['codigo'=>'0', 'texto'=>'No se observan.','categoria'=>'LH']);
        $this->insert('Leyenda', ['codigo'=>'1', 'texto'=>'Escasa cantidad (+/++++).','categoria'=>'LH']);
        $this->insert('Leyenda', ['codigo'=>'2', 'texto'=>'Leve cantidad (++/++++).','categoria'=>'LH']);
        $this->insert('Leyenda', ['codigo'=>'3', 'texto'=>'Moderada cantidad (+++/++++).','categoria'=>'LH']);
        $this->insert('Leyenda', ['codigo'=>'4', 'texto'=>'Abundante cantidad (++++/++++).','categoria'=>'LH']);        
   
    }
       public function safeDown()
    {    	
    	$this->delete('Leyenda', ['categoria'=>'LH']);
    	
    }
}
