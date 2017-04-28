<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161003_181011_initial_inserts extends Migration
{
    public function safeUp()
    {
        $this->insert('Localidad', ['nombre'=>'Tandil','cp'=>'7000']);
        $this->insert('Localidad', ['nombre'=>'Loberia','cp'=>'7635']);
        $this->insert('Localidad', ['nombre'=>'Necochea','cp'=>'7630']);
        $this->insert('Localidad', ['nombre'=>'Azul','cp'=>'7400']);
        
        $this->insert('Tipo_prestadora', ['descripcion'=>'Cobertura']);
        $this->insert('Tipo_prestadora', ['descripcion'=>'Obra Social']);
        
        $this->insert('Estudio', ['descripcion'=>'PAP', 'nombre'=>'PAP']);
        $this->insert('Estudio', ['descripcion'=>'BIOPSIA', 'nombre'=>'BIOPSIA']);         
        
    }

    public function safeDown()
    {
        $this->delete('Localidad');
        $this->delete('Tipo_prestadora');
        $this->delete('Estudio');
    }
}
