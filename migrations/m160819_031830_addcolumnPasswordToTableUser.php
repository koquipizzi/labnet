<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160819_031830_addcolumnPasswordToTableUser extends Migration
{
    public function safeUp()
    {
 		$this->addColumn('user', 'password', $this->string(30)->notNull());
    	$this->dropColumn ( 'user', 'password_hash' );
    }

    public function safeDown()
    {
    	$this->dropColumn('user', 'password', $this->string(30)->notNull());
    	$this->addColumn('user', 'password_hash', $this->integer());
    }
}
