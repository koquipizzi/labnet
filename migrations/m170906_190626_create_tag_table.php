<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m170906_190626_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('Tag', [
         //   'id' => $this->primaryKey(),
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . " NOT NULL",
            'frequency' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('Tag');
    }
}
