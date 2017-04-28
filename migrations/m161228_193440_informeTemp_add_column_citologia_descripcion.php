<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161228_193440_informeTemp_add_column_citologia_descripcion extends Migration
{
    public function safeUp()
    {
       
            $this->addColumn('InformeTemp','citologia', $this->string('1024'));
    }

    public function safeDown()
    {
            $this->dropColumn('InformeTemp','citologia');
    }
}
