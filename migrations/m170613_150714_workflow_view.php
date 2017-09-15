<?php

use yii\db\Migration;

class m170613_150714_workflow_view extends Migration
{
    public function safeUp()
    {
        $this->execute('
            CREATE VIEW view_informe_ult_workflow AS
                SELECT
                    Workflow.Informe_id AS informe_id,
                    MAX(Workflow.id) AS id
                FROM
                    Workflow
                GROUP BY Workflow.Informe_id
        ');

    }

    public function safeDown()
    {
        echo "m170613_150714_workflow_view cannot be reverted.\n";
        $this->execute('
            DROP VIEW view_informe_ult_workflow
        ');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170613_150714_workflow_view cannot be reverted.\n";

        return false;
    }
    */
}
