<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161209_184353_insert_table_Laboratorio extends Migration
{
    public function safeUp()
    {
        $this->insert('Laboratorio', [
            'nombre'=>'CIPAT',            
            'descripcion'=>'Citología y Patología Tandil',
            'direccion'=>'Gral. Rodríguez N°60 - Tandil (7000)',
            'path_logo'=>'/images/logo_cipat.png',
            'web'=>'www.cipat.com.ar',
            'telefono'=>'(0249)443-1079',
            'mail'=>'admin@cipat.com.ar',
            'info_mail'=>'info@cipat.com.ar',
            ]);
    }

    public function safeDown()
    {
        $this->truncateTable('Laboratorio');
    }
}
