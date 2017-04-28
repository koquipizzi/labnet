<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161222_130223_create_table_historial_paciente extends Migration
{
    public function safeUp()
    {
        $this->execute(" 

                        CREATE TABLE `Historial_paciente` (
                          `id` int(11) NOT NULL,
                          `fecha_entrada` date DEFAULT NULL,
                          `anio` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `letra` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `nro_secuencia` int(11) DEFAULT NULL,
                          `registro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `observaciones` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `Medico_id` int(11) NOT NULL,
                          `Procedencia_id` int(11) NOT NULL,
                          `Paciente_prestadora_id` int(11) NOT NULL,
                          `FacturarA_id` int(11) NOT NULL,
                          `fecha_entrega` date DEFAULT NULL,
                          `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `observaciones_informe` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `material` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `tecnica` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `macroscopia` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `microscopia` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `diagnostico` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `Informecol` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `Estudio_id` int(11) NOT NULL,
                          `Protocolo_id` int(11) NOT NULL,
                          `edad` int(11) DEFAULT NULL,
                          `leucositos` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `aspecto` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `calidad` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `otros` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `flora` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `hematies` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `microorganismos` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `tipo` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `nombre` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `nro_documento` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `sexo` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `fecha_nacimiento` date DEFAULT NULL,
                          `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `Tipo_documento_id` int(11) NOT NULL,
                          `Localidad_id` int(11) NOT NULL,
                          `domicilio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `notas` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `hc` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `descipcion_procedencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `domicilio_procedencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `Localidad_id_precedencia` int(11) NOT NULL,
                          `telefono_procedencia` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `informacion_adicional` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `nombre_medico` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `email_medico` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `domicilio_medico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `telefono_medico` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `Localidad_id_medico` int(11) NOT NULL,
                          `notas_medico` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                          `especialidad_id` int(11) DEFAULT NULL
                        ) ;


                    
                   " );
    }

    public function safeDown()
    {
     $this->dropTable("Historial_paciente");
        
    }
}
