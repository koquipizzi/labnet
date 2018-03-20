<?php

use yii\db\Migration;

/**
 * Class m180319_160438_Tarifas_alter_column_telefono
 */
class m180319_160438_Tarifas_alter_column_telefono extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("Paciente","telefono",$this->string("100"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn("Paciente","telefono",$this->string("20"));
    }

}
