<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161014_141237_workflow_estado_id_set_default_1 extends Migration
{
    public function safeUp()
    {

        $this->alterColumn('Workflow', 'Estado_id', $this->integer()->defaultValue('1'));

    }

    public function safeDown()
    {
        $this->alterColumn('Workflow', 'Estado_id', $this->integer());
    }
}
