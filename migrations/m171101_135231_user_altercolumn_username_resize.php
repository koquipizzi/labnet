<?php

use yii\db\Migration;

class m171101_135231_user_altercolumn_username_resize extends Migration
{
    public function safeUp()
    {
            $this->alterColumn('user','username', $this->string(200));
    }

    public function safeDown()
    {
        $this->alterColumn('user','username', $this->string(32));
    }

    
}
