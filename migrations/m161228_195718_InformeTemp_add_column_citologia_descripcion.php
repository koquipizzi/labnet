<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161228_195718_InformeTemp_add_column_citologia_descripcion extends Migration
{
      public function safeUp()
    {
           $this->dropColumn('InformeTemp','citologia');
            $this->addColumn('InformeTemp','citologia', $this->string('1024'));
    }

    public function safeDown()
    {
            $this->dropColumn('InformeTemp','citologia');
    }
}
