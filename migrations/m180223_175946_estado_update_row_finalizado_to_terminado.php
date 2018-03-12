<?php

use yii\db\Migration;

class m180223_175946_estado_update_row_finalizado_to_terminado extends Migration
{
    public function safeUp()
    {
        $this->update("Estado",["Descripcion"=>"Terminado"],["id"=>5]);
    }

    public function safeDown()
    {
         $this->update("Estado",["Descripcion"=>"Finalizado"],["id"=>5]);
    }

 
}
