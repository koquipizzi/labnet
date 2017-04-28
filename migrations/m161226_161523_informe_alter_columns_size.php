<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161226_161523_informe_alter_columns_size extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('Informe', 'descripcion', $this->string(2048));
        $this->alterColumn('Informe', 'observaciones', $this->string(2048));
        $this->alterColumn('Informe', 'diagnostico', $this->string(2048));
    }

    public function safeDown()
    {
        $this->dropColumn('Informe', 'descripcion');
        $this->dropColumn('Informe', 'observaciones');
        $this->dropColumn('Informe', 'diagnostico');
    }
}
