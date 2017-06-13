<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170302_163344_Nomenclador_alter_table extends Migration
{
    public function safeUp()
    {
        $this->execute  ("
            ALTER TABLE Nomenclador 
            DROP FOREIGN KEY fk_Nomenclador_Prestadoras_id;
            ALTER TABLE Nomenclador
            CHANGE COLUMN Prestadoras_id Prestadoras_id INT(11) NULL;
            ALTER TABLE Nomenclador
            ADD CONSTRAINT fk_Nomenclador_Prestadoras_id
                FOREIGN KEY (Prestadoras_id)
                REFERENCES Prestadoras (id)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION;
        ");
    }

    public function safeDown()
    {
    }
}
