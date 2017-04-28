<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160913_234649_create_table_sexo extends Migration
{
    public function safeUp()
    {
         $this->createTable('Sexo', [
            'id' => $this->primaryKey(),
            'descripcion' => $this->string()->notNull(),            
        ]);

        $this->insert('Sexo', [
            'descripcion' => 'Femenino',            
        ]);
         $this->insert('Sexo', [
            'descripcion' => 'Masculino',            
        ]);
    }

    public function safeDown()
    {
        $this->delete('Sexo');
        $this->dropTable('Sexo');
    }
}
