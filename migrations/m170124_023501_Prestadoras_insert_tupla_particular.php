<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170124_023501_Prestadoras_insert_tupla_particular extends Migration
{
    public function safeUp()
    {
         $this->insert('Prestadoras', ['descripcion' => 'Particular', 'email'=> 'wwed@gmail.com',
                        'domicilio'=>'Lamadrid 123','facturable' => 'S', 'Tipo_prestadora_id' =>'1', 'cobertura'=>'1', 'Localidad_id'=>'2'],1);

    }

    public function safeDown()
    {
        
    }
}
