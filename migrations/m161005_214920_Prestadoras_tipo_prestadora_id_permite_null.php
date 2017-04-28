<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161005_214920_Prestadoras_tipo_prestadora_id_permite_null extends Migration
{
    public function safeUp()
    {

        $this->alterColumn('Prestadoras', 'Tipo_prestadora_id', $this->integer()->null());

    }

    public function safeDown()
    {
        $this->alterColumn('Prestadoras', 'Tipo_prestadora_id', $this->integer()->notNull());
    }
}
