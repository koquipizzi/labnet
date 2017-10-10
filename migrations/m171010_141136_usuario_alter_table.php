<?php

use yii\db\Migration;

class m171010_141136_usuario_alter_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn("user","auth_key");
        $this->addColumn("user", "auth_key", $this->string("32")->null());
        $this->alterColumn("user","created_at",$this->string("32")->null());
        $this->alterColumn("user","updated_at",$this->string("32")->null());
      
    }

    public function safeDown()
    {
        $this->dropColumn("user","auth_key");
        $this->addColumn("user", "auth_key", $this->string("32")->notNull());
        $this->alterColumn("user","created_at",$this->string("32")->notNull());
        $this->alterColumn("user","updated_at",$this->string("32")->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171010_141136_usuario_alter_table cannot be reverted.\n";

        return false;
    }
    */
}
