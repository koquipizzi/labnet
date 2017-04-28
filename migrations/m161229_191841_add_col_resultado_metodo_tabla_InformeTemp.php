<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161229_191841_add_col_resultado_metodo_tabla_InformeTemp extends Migration
{
    public function safeUp()
    {
        $this->addColumn('InformeTemp','resultado', $this->string('1024'));
        $this->addColumn('InformeTemp','metodo', $this->string('1024'));
    }

    public function safeDown()
    {
        $this->dropColumn('InformeTemp','resultado');
        $this->dropColumn('InformeTemp','metodo');   
    }
}
