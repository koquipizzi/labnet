<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161223_133320_Trigger_UpdateHistoriaClinica_Dlt extends Migration
{
    public function safeUp()
    {
        $this->execute("DROP TRIGGER IF EXISTS UpdateHistoriaClinica_Dlt;");
        $this->execute( "
                            CREATE TRIGGER UpdateHistoriaClinica_Dlt
                            BEFORE DELETE ON Historial_paciente
                            FOR EACH ROW
                            BEGIN
                            DECLARE sgn_upd_hp CONDITION FOR SQLSTATE '45001';
                                SIGNAL SQLSTATE '45001' SET message_text = 'Prohibido Borrar Historia Clinica de Paciente';
                            END
                      ");   
    }

    public function safeDown()
    {
          $this->execute("DROP TRIGGER IF EXISTS UpdateHistoriaClinica_Dlt;");
    }
}
