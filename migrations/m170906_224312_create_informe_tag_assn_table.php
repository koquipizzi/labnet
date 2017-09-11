<?php

use yii\db\Migration;

/**
 * Handles the creation of table `informe_tag_assn`.
 */
class m170906_224312_create_informe_tag_assn_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('informe_tag_assn', [
          //  'id' => $this->primaryKey(),
            'informe_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),

        ]);
        $this->addPrimaryKey('', 'informe_tag_assn', ['informe_id', 'tag_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('informe_tag_assn');
    }
}


 