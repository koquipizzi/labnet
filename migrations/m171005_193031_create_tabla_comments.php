<?php

use yii\db\Migration;

class m171005_193031_create_tabla_comments extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%Comment}}', [
            'id' => $this->primaryKey(),
            'entity' => $this->char(10)->notNull(),
            'entityId' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'parentId' => $this->integer()->null(),
            'level' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdBy' => $this->integer()->notNull(),
            'updatedBy' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('idx-Comment-entity', '{{%Comment}}', 'entity');
        $this->createIndex('idx-Comment-status', '{{%Comment}}', 'status');

        $this->addColumn('{{%Comment}}', 'relatedTo', $this->string(500)->notNull()->after('updatedBy'));

        if (Yii::$app->db->schema->getTableSchema('{{%comment}}') === null) {
            $this->renameTable('{{%Comment}}', '{{%comment}}');
        }

        $this->addColumn('{{%comment}}', 'url', $this->text()->after('relatedTo'));
    }

    public function safeDown()
    {
        
        $this->dropTable('{{%comment}}');
  
       
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171005_193031_create_tabla_comments cannot be reverted.\n";

        return false;
    }
    */
}
