<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161014_150056_inserts_table_Estado extends Migration
{
    public function safeUp()
    {
        
        $this->insert('Estado', ['descripcion' => 'Pendiente' ]);
        $this->insert('Estado', ['descripcion' => 'Descartado' ]);
        $this->insert('Estado', ['descripcion' => 'En Proceso' ]);
        $this->insert('Estado', ['descripcion' => 'Pausado' ]);
        $this->insert('Estado', ['descripcion' => 'Terminado' ]);
        $this->insert('Estado', ['descripcion' => 'Entregado' ]);
    }

    public function safeDown()
    {
         $this->truncateTable('Estado');
    }
}
