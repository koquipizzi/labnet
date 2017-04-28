<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170103_135154_Textos_drop_column_informe_id extends Migration
{
    public function safeUp()
    {
//        $this->dropColumn("Textos", "informe_id");
    }

    public function safeDown()
    {
//            $this->addColumn("Textos", "informe_id", $this->integer());
    }
}
