<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161117_223451_inserts_user extends Migration
{
    public function safeUp()
    {
    	$this->delete('user');
    	$this->insert('user', ['username'=>'diego', 'email'=>'diego@gmail.com','status'=>'1','created_at'=>'12-12-12','updated_at'=>'12-12-12','password'=>'diego']);
    	$this->insert('user', ['username'=>'koqui', 'email'=>'koqui@gmail.com','status'=>'1','created_at'=>'12-12-12','updated_at'=>'12-12-12','password'=>'koqui']);
    	$this->insert('user', ['username'=>'federico', 'email'=>'federico@gmail.com','status'=>'1','created_at'=>'12-12-12','updated_at'=>'12-12-12','password'=>'federico']);
    	$this->insert('user', ['username'=>'fran', 'email'=>'fran@gmail.com','status'=>'1','created_at'=>'12-12-12','updated_at'=>'12-12-12','password'=>'fran']);
    	 
    }
       public function safeDown()
    {
    	
    	$this->delete('user', ['email'=>'rodrigo@gmail.com']);
    	$this->insert('user', ['email'=>'rodrigo@gmail.com']);
    	$this->insert('user', ['email'=>'rodrigo@gmail.com']);
    	$this->insert('user', ['email'=>'fran@gmail.com']);
    	
    }
}
