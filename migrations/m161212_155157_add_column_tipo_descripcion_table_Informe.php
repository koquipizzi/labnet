<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161212_155157_add_column_tipo_descripcion_table_Informe extends Migration
{
    public function safeUp()
    {
            $this->addColumn('Informe','tipo', $this->string('512'));
    }

    public function safeDown()
    {
            $this->dropColumn('Informe','tipo');
    }
}
