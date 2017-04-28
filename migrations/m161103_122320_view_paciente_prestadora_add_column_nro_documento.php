<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161103_122320_view_paciente_prestadora_add_column_nro_documento extends Migration
{
    public function safeUp()
    {
        $this->execute(" DROP VIEW  IF EXISTS `View_Paciente_Prestadora`; ");
        $this->execute("
         create view View_Paciente_Prestadora as 
        SELECT pp.id ,CONCAT(p.nombre ,' (',p.nro_documento,')','(',pt.descripcion,'-',pp.nro_afiliado,')') AS 'nombreDniDescripcionNroAfiliado',p.sexo, p.nro_documento, p.fecha_nacimiento,p.telefono as 'telefono_paciente',p.email as 'email_paciente',p.Tipo_documento_id,p.Localidad_id AS 'localidad_paciente',p.domicilio as 'domicilio_paciente'
        , pt.telefono as 'telefono_prestadora',  pt.domicilio as 'domicilio_prestadora', pt.email as 'email_prestadora',  pt.Localidad_id AS 'localidad_prestadora', pt.facturable,  pt.Tipo_prestadora_id
        FROM Paciente p JOIN Paciente_prestadora pp ON (pp.Paciente_id=p.id) 
        JOIN Prestadoras pt ON(pp.Prestadoras_id=pt.id)
        ORDER BY nombreDniDescripcionNroAfiliado ASC ;
        \"
        ");
    }

    public function safeDown()
    {
         $this->execute("DROP VIEW View_Paciente_Prestadora;");
    }
}
