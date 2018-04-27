<?php

use yii\db\Migration;

/**
 * Class m180427_170438_informe_alters_colums_varchar_to_text
 */
class m180427_170438_informe_alters_colums_varchar_to_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("Informe","descripcion",$this->text());
        $this->alterColumn("Informe","observaciones",$this->text());
        $this->alterColumn("Informe","material",$this->text());
        $this->alterColumn("Informe","tecnica",$this->text());
        $this->alterColumn("Informe","macroscopia",$this->text());
        $this->alterColumn("Informe","microscopia",$this->text());
        $this->alterColumn("Informe","diagnostico",$this->text());
        $this->alterColumn("Informe","citologia",$this->text());
        $this->alterColumn("Informe","resultado",$this->text());
        $this->alterColumn("Informe","metodo",$this->text());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }


}
