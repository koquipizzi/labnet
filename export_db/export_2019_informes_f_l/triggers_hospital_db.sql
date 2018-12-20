----------------------------------------
triggers hospital
------------------------------------------

DELIMITER $$
CREATE DEFINER=`root`@`%` TRIGGER bi_protocolo_codigo
                BEFORE INSERT ON Protocolo
                FOR EACH ROW
            BEGIN
                SET NEW.codigo = CONCAT(SUBSTRING(NEW.anio,-2),NEW.letra,'-', LPAD(NEW.nro_secuencia, 6, 0));
            END
DELIMITER $$
CREATE DEFINER=`root`@`%` TRIGGER bu_protocolo_codigo
                BEFORE UPDATE ON Protocolo
                FOR EACH ROW
            BEGIN
                SET NEW.codigo = CONCAT(SUBSTRING(NEW.anio,-2),NEW.letra,'-', LPAD(NEW.nro_secuencia, 6, 0));
            END
DELIMITER $$
CREATE DEFINER= `root`@`%` TRIGGER Reset_nro_secuencia
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
            END
;
alter table Protocolo add prueba int(2) ;            
update Protocolo set prueba=1 where id>0;

DELIMITER $$
CREATE DEFINER=`root`@`%` TRIGGER ActualizacionEstado_Ins
                            AFTER INSERT ON Workflow
                            FOR EACH ROW
                            BEGIN
                            UPDATE Informe SET estado_actual = NEW.Estado_id WHERE id = NEW.Informe_id;
                            END
DELIMITER $$
CREATE DEFINER=`root`@`%` TRIGGER ActualizacionEstado_Upd
                        AFTER UPDATE ON Workflow
                        FOR EACH ROW
                        BEGIN
                        UPDATE Informe SET estado_actual = NEW.Estado_id WHERE id = NEW.Informe_id;
                        END
DELIMITER $$
CREATE DEFINER=`root`@`%` TRIGGER UpdateHistoriaClinica_Dlt
                            BEFORE DELETE ON Historial_paciente
                            FOR EACH ROW
                            BEGIN
                            DECLARE sgn_upd_hp CONDITION FOR SQLSTATE '45001';
                                SIGNAL SQLSTATE '45001' SET message_text = 'Prohibido Borrar Historia Clinica de Paciente';
                            END
DELIMITER $$
CREATE DEFINER=`root`@`%` TRIGGER UpdateHistoriaClinica_Upd
                            BEFORE UPDATE ON Historial_paciente
                            FOR EACH ROW
                            BEGIN
                            DECLARE sgn_upd_hp CONDITION FOR SQLSTATE '45000';
                                SIGNAL SQLSTATE '45000' SET message_text = 'Prohibido Actualizar Historia Clinica de Paciente';
                            END



