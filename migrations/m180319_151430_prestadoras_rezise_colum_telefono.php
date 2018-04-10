<?php

use yii\db\Migration;

/**
 * Class m180319_151430_prestadoras_rezise_colum_telefono
 */
class m180319_151430_prestadoras_rezise_colum_telefono extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("Prestadoras","telefono",$this->string("100"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn("Prestadoras","telefono",$this->string("20"));
    }

}
