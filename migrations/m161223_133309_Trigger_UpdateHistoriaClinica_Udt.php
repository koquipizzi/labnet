<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161223_133309_Trigger_UpdateHistoriaClinica_Udt extends Migration
{
    public function safeUp()
    {
        $this->execute("DROP TRIGGER IF EXISTS UpdateHistoriaClinica_Upd;");
        $this->execute( "  
                            
                            CREATE TRIGGER UpdateHistoriaClinica_Upd
                            BEFORE UPDATE ON Historial_paciente
                            FOR EACH ROW
                            BEGIN
                            DECLARE sgn_upd_hp CONDITION FOR SQLSTATE '45000';
                                SIGNAL SQLSTATE '45000' SET message_text = 'Prohibido Actualizar Historia Clinica de Paciente';
                            END;$$
                            DELIMITER ;
                      ");   
    }

    public function safeDown()
    {
             $this->execute("DROP TRIGGER IF EXISTS UpdateHistoriaClinica_Upd;");
    }
}
