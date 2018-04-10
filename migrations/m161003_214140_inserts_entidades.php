<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161003_214140_inserts_entidades extends Migration
{
    public function safeUp()
    {
        return true;
        $this->insert('Procedencia', ['descipcion'=>'Hospital', 'Localidad_id'=>'2']);
        $this->insert('Procedencia', ['descipcion'=>'Clinica', 'Localidad_id'=>'2']);
        $this->insert('Procedencia', ['descipcion'=>'Otra Procedencia', 'Localidad_id'=>'1']);

        $this->insert('Medico', ['nombre' => 'Jorge Diaz', 'email'=> 'jd@gmail.com',
                                 'especialidad' => 'Clinico', 'domicilio'=>'Las Heras 123',
                                 'telefono' => '4423454', 'Localidad_id'=>'3']);
        $this->insert('Medico', ['nombre' => 'Gastón Perez', 'email'=> 'wwed@gmail.com',
                                 'especialidad' => 'Clinico', 'domicilio'=>'Lamadrid 123',
                                 'telefono' => '4428854', 'Localidad_id'=>'3']);
        $this->insert('Prestadoras', ['descripcion' => 'Prestadora 1', 'email'=> 'wwed@gmail.com',
                        'domicilio'=>'Lamadrid 123','facturable' => 'N', 'Tipo_prestadora_id' =>'1', 'cobertura'=>'1', 'Localidad_id'=>'2']);

        $this->insert('Prestadoras', ['descripcion' => 'Prestadora 2', 'email'=> 'oopped@gmail.com',
                'domicilio'=>'Bs As 123','facturable' => 'S', 'Tipo_prestadora_id' =>'2', 'cobertura'=>'2', 'Localidad_id'=>'3']);

        $this->insert('Paciente', ['nombre' => 'Marcelo Ricardo', 'email'=> 'mariojd@gmail.com',
                                  'domicilio'=>'Las Heras 329','telefono' => '4423454', 'Localidad_id'=>'3', 'Tipo_documento_id'=>'1', 'nro_documento'=>'255669455']);

        $this->insert('Paciente', ['nombre' => 'Julieta Venegas', 'email'=> 'jvenegas@gmail.com',
                                  'domicilio'=>'Las Heras 329','telefono' => '4423454', 'Localidad_id'=>'3', 'Tipo_documento_id'=>'1', 'nro_documento'=>'22334455']);


        $this->insert('Paciente_prestadora', ['nro_afiliado' => 'AA2376-D', 'Paciente_id'=> '2',
                                  'Prestadoras_id'=>'1']);

        $this->insert('Paciente_prestadora', ['nro_afiliado' => 'AA2376-D', 'Paciente_id'=> '1',
                                  'Prestadoras_id'=>'2']);

        $this->insert('Nomenclador', ['descripcion' => 'Descartable 2', 'valor'=> '15',
                                  'Prestadoras_id'=>'2','servicio'=>'1', 'coseguro'=>'5' ]);

        $this->insert('Nomenclador', ['descripcion' => 'Descartable 33', 'valor'=> '19',
                                  'Prestadoras_id'=>'1','servicio'=>'1', 'coseguro'=>'5' ]);

       



    }

    public function safeDown()
    {
        return true;
        $this->truncateTable('Nomenclador');
        $this->truncateTable('Paciente_prestadora');
        $this->truncateTable('Paciente');
        $this->truncateTable('Prestadoras');
        $this->truncateTable('Medico');
        $this->truncateTable('Procedencia');
         
              
    }
}
