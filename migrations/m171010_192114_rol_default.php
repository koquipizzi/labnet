<?php

use yii\db\Migration;

class m171010_192114_rol_default extends Migration
{
    public function safeUp()
    {


               //Agregar rool default
 
        $this->execute("
        insert into auth_item (name,type) 
        select * from (select 'rolDefault',1 ) as tmp
        where not EXISTS (
        SELECT 1 FROM `auth_item` WHERE name='rolDefault' and type=1
        )LIMIT 1;

       "
        );



        /************************rolDefault-site**********************************************/
         $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/site/*' ) as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/site/*'
                and aic.parent=ai.name 
                and ai.type=1
                )LIMIT 1;
             "
        );



        /************************rolDefault-paciente**********************************************/

         $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/protocolo/*' ) as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/protocolo/*'
                and aic.parent=ai.name 
                and ai.type=1
                )LIMIT 1;
             "
        );



        /************************rolDefault-paciente**********************************************/

         $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/paciente/index' ) as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/paciente/index'
                and aic.parent=ai.name 
                and ai.type=1
                )LIMIT 1;
             "
        );

         $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/paciente/create' ) as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/paciente/create'
                and aic.parent=ai.name 
                and ai.type=1
                )LIMIT 1;
             "
        );

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
                )LIMIT 1;
             "
        );



        /********************fin Paciente********************/

        /********************rolDefault-Medico********************/

         $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/medico/index' ) as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/medico/index'
                and aic.parent=ai.name 
                and ai.type=1
                )LIMIT 1;
             "
        );      
        
         $this->execute(
             "
                insert into auth_item_child (parent,child) 
                select * from (select 'rolDefault','/medico/create' ) as tmp
                where not EXISTS (
                SELECT 1 
                FROM auth_item_child aic join auth_item ai
                WHERE parent='rolDefault' 
                and child='/medico/create' 
                and aic.parent=ai.name 
                and ai.type=1
                )LIMIT 1;
             "
        );          

        /********************fin Medico********************/
     
    }

    public function safeDown()
    {
         $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/site/*"]);
        
        $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/medico/index"]);        
        $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/medico/create"]);

        $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/paciente/create"]);
        $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/paciente/index"]);
       // $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/paciente/buscar"]);
        
        $this->delete('auth_item_child', ['parent' => 'rolDefault','child'=>"/protocolo/*"]);

        $this->execute("delete from auth_item 
                        where name='rolDefault'
                        and type=1 
                        and not exists
                            ( 
                                 select 1 from auth_assignment where item_name='rolDefault'
                             );"
                    );
    }

}
