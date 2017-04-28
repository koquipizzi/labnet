<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160913_233550_insert_tipo_doc extends Migration
{
    public function safeUp()
    {
        $this->insert('Tipo_documento', [           
            'descripcion' => 'DNI',
        ]);
        $this->insert('Tipo_documento', [           
            'descripcion' => 'LC',
        ]);
        $this->insert('Tipo_documento', [           
            'descripcion' => 'LE',
        ]);
        $this->insert('Tipo_documento', [           
            'descripcion' => 'Pasaporte',
        ]);
    }

    public function safeDown()
    {
        $this->delete('Tipo_documento');
    }
}
