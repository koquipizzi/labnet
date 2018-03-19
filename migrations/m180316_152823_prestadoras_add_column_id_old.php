<?php

use yii\db\Migration;

/**
 * Class m180316_152823_prestadoras_add_column_id_old
 */
class m180316_152823_prestadoras_add_column_id_old extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("Prestadoras","id_old",$this->integer(11));
        $this->addColumn("Procedencia","id_old",$this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn("Prestadoras","id_old");
       $this->addColumn("Procedencia","id_old");
    }
}
