<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161227_183207_User_add_column_password_hash extends Migration
{
    public function safeUp()
    {
        $this->addColumn("user","password_hash",$this->string(512));
    }

    public function safeDown()
    {
         $this->dropColumn("user","password_hash");
    }
}
