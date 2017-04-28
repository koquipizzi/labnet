<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170119_171001_Create_table_Pago extends Migration
{
    public function safeUp()
    {
           $this->createTable('Pago', [
            'id' => $this->primaryKey(),
            'fecha' => $this->date()->notNull(),
            'inporte'=>$this->integer()->notNull(),
            'nro_formulario' => $this->integer(),
            'observaciones' => $this->text(2048),
            'Prestadoras_id' => $this->integer()->notNull(),
           
        ]);
            $this->addForeignKey(
            'fk_pago_prestadora',
            'Pago',
            'Prestadoras_id',
            'Prestadoras',
            'id',
            'CASCADE'
        );
    }
    
    


    public function safeDown()
    {
        $this->dropTable("Pago");
    }   
}
