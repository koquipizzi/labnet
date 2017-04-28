<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160814_205944_rbac extends Migration
{
    public function safeUp()
    {
// auth_assignment
$this->createTable('{{%auth_assignment}}', [
    'item_name' => Schema::TYPE_STRING . "(64) NOT NULL",
    'user_id' => Schema::TYPE_STRING . "(64) NOT NULL",
    'created_at' => Schema::TYPE_INTEGER . "(11) NULL",
    'PRIMARY KEY (item_name, user_id)',
], $this->tableOptions);

// auth_item
$this->createTable('{{%auth_item}}', [
    'name' => Schema::TYPE_STRING . "(64) NOT NULL",
    'type' => Schema::TYPE_INTEGER . "(11) NOT NULL",
    'description' => Schema::TYPE_TEXT . " NULL",
    'rule_name' => Schema::TYPE_STRING . "(64) NULL",
    'data' => Schema::TYPE_TEXT . " NULL",
    'created_at' => Schema::TYPE_INTEGER . "(11) NULL",
    'updated_at' => Schema::TYPE_INTEGER . "(11) NULL",
    'PRIMARY KEY (name)',
], $this->tableOptions);

// auth_item_child
$this->createTable('{{%auth_item_child}}', [
    'parent' => Schema::TYPE_STRING . "(64) NOT NULL",
    'child' => Schema::TYPE_STRING . "(64) NOT NULL",
    'PRIMARY KEY (parent, child)',
], $this->tableOptions);

// auth_rule
$this->createTable('{{%auth_rule}}', [
    'name' => Schema::TYPE_STRING . "(64) NOT NULL",
    'data' => Schema::TYPE_TEXT . " NULL",
    'created_at' => Schema::TYPE_INTEGER . "(11) NULL",
    'updated_at' => Schema::TYPE_INTEGER . "(11) NULL",
    'PRIMARY KEY (name)',
], $this->tableOptions);

// menu
$this->createTable('{{%menu}}', [
    'id' => Schema::TYPE_PK,
    'name' => Schema::TYPE_STRING . "(128) NOT NULL",
    'parent' => Schema::TYPE_INTEGER . "(11) NULL",
    'route' => Schema::TYPE_STRING . "(255) NULL",
    'order' => Schema::TYPE_INTEGER . "(11) NULL",
    'data' => Schema::TYPE_BINARY . " NULL",
], $this->tableOptions);

// user
$this->createTable('{{%user}}', [
    'id' => Schema::TYPE_PK,
    'username' => Schema::TYPE_STRING . "(32) NOT NULL",
    'auth_key' => Schema::TYPE_STRING . "(32) NOT NULL",
    'password_hash' => Schema::TYPE_STRING . "(255) NOT NULL",
    'password_reset_token' => Schema::TYPE_STRING . "(255) NULL",
    'email' => Schema::TYPE_STRING . "(255) NOT NULL",
    'status' => Schema::TYPE_SMALLINT . "(6) NOT NULL DEFAULT '10'",
    'created_at' => Schema::TYPE_INTEGER . "(11) NOT NULL",
    'updated_at' => Schema::TYPE_INTEGER . "(11) NOT NULL",
], $this->tableOptions);

// fk: auth_assignment
$this->addForeignKey('fk_auth_assignment_item_name', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name');

// fk: auth_item
$this->addForeignKey('fk_auth_item_rule_name', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name');

// fk: auth_item_child
$this->addForeignKey('fk_auth_item_child_parent', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name');
$this->addForeignKey('fk_auth_item_child_child', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name');

// fk: menu
$this->addForeignKey('fk_menu_parent', '{{%menu}}', 'parent', '{{%menu}}', 'id');


    }

    public function safeDown()
    {

        // fk: auth_assignment
$this->dropForeignKey('fk_auth_assignment_item_name', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name');

// fk: auth_item
$this->dropForeignKey('fk_auth_item_rule_name', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name');

// fk: auth_item_child
$this->dropForeignKey('fk_auth_item_child_parent', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name');
$this->dropForeignKey('fk_auth_item_child_child', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name');

// fk: menu
$this->dropForeignKey('fk_menu_parent', '{{%menu}}', 'parent', '{{%menu}}', 'id');

		$this->dropTable('{{%auth_assignment}}');
		$this->dropTable('{{%auth_item}}'); // fk: rule_name
		$this->dropTable('{{%auth_item_child}}'); // fk: child, parent
		$this->dropTable('{{%auth_rule}}');
		$this->dropTable('{{%menu}}'); // fk: parent
		$this->dropTable('{{%user}}');

    }
}
