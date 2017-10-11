<?php

use yii\db\Migration;

class m171011_152233_rol_defgault_add_varios extends Migration
{
    public function safeUp()
    {
            $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/datecontrol/*') as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/datecontrol/*'
                and aic.parent=ai.name 
                and ai.type=1
            )
                LIMIT 1;
             "
        );
    }

    public function safeDown()
    {
        

          $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/datecontrol/*"]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171011_152233_rol_defgault_add_varios cannot be reverted.\n";

        return false;
    }
    */
}
