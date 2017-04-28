<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161014_185500_workflow_responsable_id_nullable extends Migration
{
    public function safeUp()
        {

            $this->alterColumn('Workflow', 'Responsable_id', $this->integer()->null());

        }

    public function safeDown()
        {
            $this->alterColumn('Workflow', 'Responsable_id', $this->integer());
        }
}
