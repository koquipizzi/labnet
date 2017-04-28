<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170224_224403_fix_nro_secuencia extends Migration
{
 public function safeUp()
    {
        
        $this->addColumn("Nro_secuencia_protocolo", "secuencia_diff", $this->integer());
        $this->addColumn("Nro_secuencia_protocolo", "secuencia", $this->integer());
        $this->execute("
                            DROP TRIGGER IF EXISTS Reset_nro_secuencia;
                            DROP EVENT IF EXISTS DeleteOLD_nro_secuencia;
                            DELIMITER $$
                            CREATE TRIGGER Reset_nro_secuencia
                            BEFORE INSERT ON Nro_secuencia_protocolo
                            FOR EACH ROW
                            BEGIN
                            DECLARE anioActual INT;
                                DECLARE lastId INT;
                                DECLARE diff INT;

                                -- Obtiene el anio del ultimo registro
                            SELECT YEAR(Nro_secuencia_protocolo.fecha), Nro_secuencia_protocolo.id, Nro_secuencia_protocolo.secuencia_diff into anioActual, lastId, diff
                            FROM Nro_secuencia_protocolo 
                            ORDER BY id DESC LIMIT 1;

                                -- No hay registros en la tabla
                                IF anioActual IS NULL THEN
                            SET anioActual = YEAR(NEW.fecha);
                                    SET lastId = 0;
                                    SET diff = 0;  
                            END IF; 

                            -- Compara con el Anio del nuevo registro
                            IF( YEAR(NEW.fecha) > anioActual ) THEN
                            SET NEW.secuencia_diff = lastId;
                            ELSE 
                            SET NEW.secuencia_diff = diff;
                            END IF;

                                SET NEW.secuencia = lastId - New.secuencia_diff;
                            END;
                            $$
                            DELIMITER ;
                            DELIMITER $$
                            CREATE EVENT IF NOT EXISTS DeleteOLD_nro_secuencia
                            ON SCHEDULE EVERY 30 second
                            DO
                            BEGIN
                            DECLARE anioActual INT;
                                DECLARE anioInicial INT;
                                DECLARE lastId INT;

                                -- Obtiene el anio del primer registro
                            SELECT YEAR(Nro_secuencia_protocolo.fecha) into anioInicial
                            FROM Nro_secuencia_protocolo 
                            ORDER BY id ASC LIMIT 1;

                                -- Obtiene el anio del ultimo registro
                            SELECT YEAR(Nro_secuencia_protocolo.fecha), Nro_secuencia_protocolo.id into anioActual, lastId
                            FROM Nro_secuencia_protocolo 
                            ORDER BY id DESC LIMIT 1; 

                            -- Compara con el Anio del nuevo registro
                            IF( anioInicial < anioActual ) THEN
                            DELETE FROM Nro_secuencia_protocolo WHERE id < lastId;
                            END IF;
                            END; 
                            $$
                            DELIMITER ;
                            SET GLOBAL event_scheduler = ON;
                            SET @@global.event_scheduler = ON;
                            SET GLOBAL event_scheduler = 1;
                            SET @@global.event_scheduler = 1;
                            truncate Nro_secuencia_protocolo;                        
                        ");
    }

    public function safeDown()
    {
        $this->dropColumn("Nro_secuencia_protocolo", "secuencia_diff");
        $this->dropColumn("Nro_secuencia_protocolo", "secuencia");
        $this->execute("DROP TRIGGER IF EXISTS Reset_nro_secuencia");
    }
}
