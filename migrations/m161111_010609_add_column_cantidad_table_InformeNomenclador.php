<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161111_010609_add_column_cantidad_table_InformeNomenclador extends Migration
{
     public function safeUp()
    {
        $this->addColumn('InformeNomenclador', 'cantidad', $this->integer()->defaultValue(1));
    }

    public function safeDown()
    {
        $this->dropColumn('InformeNomenclador', 'cantidad');
    }
}
