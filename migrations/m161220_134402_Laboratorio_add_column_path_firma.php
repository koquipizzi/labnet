<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161220_134402_Laboratorio_add_column_path_firma extends Migration
{
    public function safeUp()
    {
        $this->addColumn("Laboratorio",
                         'path_firma', $this->string()
                        );
    }

    public function safeDown()
    {
          $this->dropColumn("Laboratorio",'path_firma');
    }
}
