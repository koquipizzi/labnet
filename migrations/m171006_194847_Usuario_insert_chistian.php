<?php

use yii\db\Migration;



class m171006_194847_Usuario_insert_chistian extends Migration
{
    public function safeUp()
    {
        $fecha= new \DateTime('now', new \DateTimeZone('UTC'));
        $f= $fecha->getTimestamp();
        $this->execute("
                        INSERT INTO `user` (`id`, `username`, `auth_key`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `password`, `password_hash`)
                         VALUES (NULL, 'christian', '', NULL, 'christian@gmail.com', '10',".$f.",".$f.", 'christian', NULL)");

    
        $this->execute("
                        INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) 
                        select 'Medico',u.id, ".$f."
                        from user u
                         where  u.username='christian' and u.email='christian@gmail.com'
                         limit 1" );  
    }

    public function safeDown()
    {
		 
          $this->execute("
                        delete from auth_assignment
                        where item_name ='Medico' and user_id=(
                            select u.id
                            from user u
                            where  u.username='christian' and u.email='christian@gmail.com'
                            limit 1)"
                        );
           $this->execute("delete from user where username='christian' and email='christian@gmail.com'");
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_194847_Usuario_insert_chistian cannot be reverted.\n";

        return false;
    }
    */
}
