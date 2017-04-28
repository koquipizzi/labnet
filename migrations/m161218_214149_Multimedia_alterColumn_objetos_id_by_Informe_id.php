<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161218_214149_Multimedia_alterColumn_objetos_id_by_Informe_id extends Migration
{
    public function safeUp()
    {
        $this->dropColumn("Multimedia", "objetos_id");
        $this->addColumn("Multimedia",
                         "Informe_id", $this->integer()
                        );
    }

    public function safeDown()
    {
            $this->dropColumn("Multimedia", "Informe_id");
            $this->addColumn("Multimedia",
                                "objetos_id",
                                 $this->integer()   
                            );
    }
}
