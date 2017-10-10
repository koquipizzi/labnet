<?php

use yii\db\Migration;

class m171010_144745_usuario_alter_column2 extends Migration
{
    public function safeUp()
    {
        $this->alterColumn("user","created_at",$this->date()->null());
        $this->alterColumn("user","updated_at",$this->date()->null());
    }

    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171010_144745_usuario_alter_column2 cannot be reverted.\n";

        return false;
    }
    */
}
