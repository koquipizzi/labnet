<?php

use yii\db\Migration;

/**
 * Class m180418_125719_add_colums_id_old
 */
class m180418_125719_add_colums_id_old extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

       $this->addColumn("Procedencia","id_old",$this->integer(11));
       $this->addColumn("Prestadoras","id_old",$this->integer(11));
       $this->addColumn("Paciente","id_old",$this->integer(11));
       $this->addColumn("Protocolo","id_old",$this->integer(11));
       $this->addColumn("Medico","id_old",$this->integer(11));


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("Procedencia","id_old");
        $this->dropColumn("Prestadoras","id_old");
        $this->dropColumn("Paciente","id_old");
        $this->dropColumn("Protocolo","id_old");
        $this->dropColumn("Medico","id_old");
    }

    }


