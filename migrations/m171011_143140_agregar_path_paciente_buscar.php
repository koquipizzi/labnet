<?php

use yii\db\Migration;

class m171011_143140_agregar_path_paciente_buscar extends Migration
{
    public function safeUp()
    {
        
        $fecha= new \DateTime('now', new \DateTimeZone('UTC'));
        $f= $fecha->getTimestamp();
        $this->execute(
                        "
                            insert into auth_item (name,type,created_at)
                            select  * from	(select '/paciente/buscar',2,".$f.") as tmp
                            where not exists (select 1 from auth_item where name='/paciente/buscar' and type=2)
                        "
                        );


    }

    public function safeDown()
    {
          $this->execute("
                        delete from auth_item 
                        where name='/paciente/buscar'
                        and type=2"
                        
                    );
    }

    
}
