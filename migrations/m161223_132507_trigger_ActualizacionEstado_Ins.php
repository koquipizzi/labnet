<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161223_132507_trigger_ActualizacionEstado_Ins extends Migration
{
    public function safeUp()
    {
   
        $this->execute("DROP TRIGGER IF EXISTS ActualizacionEstado_Ins;");
//        $this->execute("  DELIMITER $$");
        $this->execute("
            
                           
                            CREATE TRIGGER ActualizacionEstado_Ins
                            AFTER INSERT ON Workflow
                            FOR EACH ROW
                            BEGIN
                            UPDATE Informe SET estado_actual = NEW.Estado_id WHERE id = NEW.Informe_id;
                            END;$$
                            DELIMITER ;
                       " );
//        $this->execute("  DELIMITER ;");
    }

    public function safeDown()
    {
        $this->execute("DROP TRIGGER IF EXISTS ActualizacionEstado_Ins;");
    }
}
