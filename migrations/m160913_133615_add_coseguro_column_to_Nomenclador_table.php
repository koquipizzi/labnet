<?php

use yii\db\Migration;

/**
 * Handles adding coseguro to table `nomenclador`.
 */
class m160913_133615_add_coseguro_column_to_Nomenclador_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('Nomenclador', 'coseguro', $this->decimal(5,2));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('Nomenclador', 'coseguro');
    }
}
