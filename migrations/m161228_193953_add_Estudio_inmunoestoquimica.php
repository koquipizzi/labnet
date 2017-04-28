<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161228_193953_add_Estudio_inmunoestoquimica extends Migration
{
    public function safeUp()
    {
            $this->insert('Estudio', [
            'nombre'=>'INMUNOHISTOQUIMICO ',            
            'descripcion'=>'INMUNOHISTOQUIMICO (IHQ)',
            'titulo'=>'ESTUDIO INMUNOHISTOQUIMICO (IHQ)',
            ]);
    }

    public function safeDown()
    {
            $this->truncateTable('Estudio');
    }
}
