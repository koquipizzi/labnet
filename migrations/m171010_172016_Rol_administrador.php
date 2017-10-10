<?php

use yii\db\Migration;

class m171010_172016_Rol_administrador extends Migration
{
    public function safeUp()
    {

    // rol admin

       $this->execute("
        insert into auth_item (name,type) 
        select * from (select '/*',2 ) as tmp
        where not EXISTS (
        SELECT 1 FROM `auth_item` WHERE name='/*' and type=2
        )LIMIT 1;

       "
        );

      
        $this->execute("
        insert into auth_item (name,type) 
        select * from (select 'Administrador',1 ) as tmp
        where not EXISTS (
        SELECT 1 FROM `auth_item` WHERE name='Administrador' and type=1
        )LIMIT 1;

       "
        );
         $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'Administrador','/*' ) as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='Administrador' 
                and child='/*'
                and aic.parent=ai.name 
                and ai.type=1
                )LIMIT 1;
             "
        );



    }

    public function safeDown()
    {
        $this->delete('auth_item_child', ['parent' => 'Administrador','child'=>"/*"]);

        $this->execute("delete from auth_item 
                        where name='Administrador'
                        and type=1 
                        and not exists
                            ( 
                                 select 1 from auth_assignment where item_name='Administrador'
                             );"
                    );
    }


}
