<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161117_165236_Workflow_alter_change_fk_to_table_user extends Migration
{
    public function safeUp()
    {
    	$this->truncateTable("Workflow");
    	$this->addForeignKey(
    			'fk-workflow-user',
    			'Workflow',
    			'Responsable_id',
    			'user',
    			'id',
    			'CASCADE'
    			);
    	$this->dropForeignKey('fk_Workflow_Responsable_id' ,"Workflow");
    	
    }

    public function safeDown()
    {
    	$this->dropForeignKey('fk-workflow-user' ,"Workflow");
    	$this->addForeignKey(
    			'fk_Workflow_Responsable_id',
    			'Workflow',
    			'Responsable_id',
    			'Responsable',
    			'id',
    			'CASCADE'
    			);
    }
}
