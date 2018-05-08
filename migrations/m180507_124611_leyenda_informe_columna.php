<?php

use yii\db\Migration;

/**
 * Class m180507_124611_leyenda_informe_columna
 */
class m180507_124611_leyenda_informe_columna extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("Laboratorio","leyenda_informe",$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("Laboratorio","leyenda_informe");

        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180507_124611_leyenda_informe_columna cannot be reverted.\n";

        return false;
    }
    */
}
