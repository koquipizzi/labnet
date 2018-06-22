<?php

use yii\db\Migration;

/**
 * Class m180622_122609_nomenclador_resize_column_descripcion
 */
class m180622_122609_nomenclador_resize_column_descripcion extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("Nomenclador","descripcion",$this->string(2048) );
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn("Nomenclador","descripcion",$this->string(200) );
    }

   
}
