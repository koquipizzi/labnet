<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160927_151016_addColumnCoberturaToPrestadora extends Migration
{
    public function safeUp()
    {

        $this->addColumn('Prestadoras', 'cobertura', $this->integer());

    }

    public function safeDown()
    {
        $this->dropColumn('Prestadoras', 'cobertura');
    }
}
