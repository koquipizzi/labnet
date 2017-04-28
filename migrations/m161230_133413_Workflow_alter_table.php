<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161230_133413_Workflow_alter_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn("Workflow", "fecha_inicio", $this->string());
         $this->alterColumn("Workflow", "fecha_fin", $this->string());
    }

    public function safeDown()
    {
         $this->alterColumn("Workflow", "fecha_inicio", $this->date());
           $this->alterColumn("Workflow", "fecha_fin", $this->date());
    }
}
