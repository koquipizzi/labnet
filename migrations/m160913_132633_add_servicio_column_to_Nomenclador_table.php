<?php

use yii\db\Migration;

/**
 * Handles adding servicio to table `nomenclador`.
 */
class m160913_132633_add_servicio_column_to_Nomenclador_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('Nomenclador', 'servicio', $this->string(30)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('Nomenclador', 'servicio');
    }
}
