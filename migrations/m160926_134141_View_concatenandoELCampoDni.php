<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160926_134141_View_concatenandoELCampoDni extends Migration
{
    public function safeUp()
    {

        $this->execute(" DROP VIEW  IF EXISTS `View_Paciente_Prestadora`; ");
        $this->execute("
         create view View_Paciente_Prestadora as 
        SELECT p.id , CONCAT(p.nombre ,' (',p.nro_documento,')','(',pt.descripcion,'-',pp.nro_afiliado,')') AS 'nombreDniDescripcionNroAfiliado',p.sexo,p.fecha_nacimiento,p.telefono as 'telefono_paciente',p.email as 'email_paciente',p.Tipo_documento_id,p.Localidad_id AS 'localidad_paciente',p.domicilio as 'domicilo_paciente'
        , pt.telefono as 'telefono_prestadora',  pt.domicilio as 'domicilio_prestadora', pt.email as 'email_prestadora',  pt.Localidad_id AS 'localidad_prestadora', pt.facturable,  pt.Tipo_prestadora_id
        FROM Paciente p JOIN Paciente_prestadora pp ON (pp.Paciente_id=p.id) 
        JOIN Prestadoras pt ON(pp.Prestadoras_id=pt.id);
        "
        );

//$this->createView('viewName', ' SELECT * FROM Paciente limit 1');
    }

    public function safeDown()
    {
        $this->execute("
                       drop view View_Paciente_Prestadora;
                       ");
    }
}
