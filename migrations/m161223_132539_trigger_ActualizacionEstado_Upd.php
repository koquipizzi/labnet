<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161223_132539_trigger_ActualizacionEstado_Upd extends Migration
{
  public function safeUp()
    {
   
       $this->execute("DROP TRIGGER IF EXISTS ActualizacionEstado_Upd;");
        
        $this->execute("
                      
                        CREATE TRIGGER ActualizacionEstado_Upd
                        AFTER UPDATE ON Workflow
                        FOR EACH ROW
                        BEGIN
                        UPDATE Informe SET estado_actual = NEW.Estado_id WHERE id = NEW.Informe_id;
                        END;$$
                        DELIMITER ;
                        ");
    }

    public function safeDown()
    {
          $this->execute("DROP TRIGGER IF EXISTS ActualizacionEstado_Upd;");
    }
}
