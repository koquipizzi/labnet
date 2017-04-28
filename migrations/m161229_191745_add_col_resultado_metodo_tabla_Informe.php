<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161229_191745_add_col_resultado_metodo_tabla_Informe extends Migration
{
    public function safeUp()
    {
        $this->addColumn('Informe','resultado', $this->string('1024'));
        $this->addColumn('Informe','metodo', $this->string('1024'));
    }

    public function safeDown()
    {
        $this->dropColumn('Informe','resultado');
        $this->dropColumn('Informe','metodo');   
    }
}
