<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160823_181605_view_paciente_prestadora extends Migration
{
    public function safeUp()
    {
        
    $this->execute("
       create view View_Paciente_Prestadora as 
        SELECT p.id , pp.nro_afiliado,p.nombre,p.nro_documento,p.sexo,p.fecha_nacimiento,p.telefono as 'telefono_paciente',p.email as 'email_paciente',p.Tipo_documento_id,p.Localidad_id AS 'localidad_paciente',p.domicilio as 'domicilo_paciente',
        pt.descripcion, pt.telefono as 'telefono_prestadora',  pt.domicilio as 'domicilio_prestadora', pt.email as 'email_prestadora',  pt.Localidad_id AS 'localidad_prestadora', pt.facturable,  pt.Tipo_prestadora_id
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
