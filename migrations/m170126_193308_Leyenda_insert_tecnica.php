<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170126_193308_Leyenda_insert_tecnica extends Migration
{
    public function safeUp()
    {
        $this->insert("Leyenda", ["codigo"=>"Tecnica","texto"=>"Fijación el alcohol 96 y coloración de rutina con técnica de Papanicolaou.", "categoria"=>"PAP"]);
    }

    public function safeDown()
    {
        
    }
}
