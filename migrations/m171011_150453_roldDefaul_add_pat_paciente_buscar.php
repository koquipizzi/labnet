<?php

use yii\db\Migration;

class m171011_150453_roldDefaul_add_pat_paciente_buscar extends Migration
{
    public function safeUp()
    {
        
       $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/paciente/buscar') as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/paciente/buscar'
                and aic.parent=ai.name 
                and ai.type=1
                )
                 and exists(
                    select * from auth_item where name='/paciente/buscar'
                )
                LIMIT 1;
             "
        );
    }

    public function safeDown()
    {
     $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/paciente/buscar"]);
    /*   $this->execute("
                        delete from auth_item_child 
                        where parent='rolDefault' 
                        and child='/paciente/buscar'
                        "
                    );
                        /*
                        and exists (
                            select 1
                            from auth_item_child
                            where parent = 'rolDefault'
                            and child ='/paciente/buscar'
                        )
                        */
                        
    }

   
}
