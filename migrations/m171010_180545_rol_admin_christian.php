<?php

use yii\db\Migration;

class m171010_180545_rol_admin_christian extends Migration
{
    public function safeUp()
    {
        $this->execute("
                        INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) 
                        select 'Administrador',u.id, now()
                        from user u
                        where  u.username='christian' and u.email='christian@gmail.com'
                        limit 1" 
                     );  
    }

    public function safeDown()
    {
        $this->execute("
                        delete from auth_assignment
                        where item_name ='Administrador' and user_id=(
                            select u.id
                            from user u
                            where  u.username='christian' and u.email='christian@gmail.com'
                            limit 1)"
                        );
    }

  
}
