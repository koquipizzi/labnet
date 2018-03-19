<?php

use yii\db\Migration;

/**
 * Class m180316_151340_nomenclador_resize_descripcion_to_200_caracteres
 */
class m180316_151340_nomenclador_resize_descripcion_to_200_caracteres extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("Nomenclador","descripcion",$this->string(200));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn("Nomenclador","descripcion",$this->string(45));
    }

}
