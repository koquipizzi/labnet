<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170126_194943_Leyenda_update_text_material extends Migration
{
    public function safeUp()
    {
        $this->update("Leyenda", ["texto"=>"Extendido cervico-vaginal (Citología exfoliativa oncológica y hormonal)."], ["codigo"=>"Material", "categoria"=>"PAP"]);
    }

    public function safeDown()
    {
    }
}
