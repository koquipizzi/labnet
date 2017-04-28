<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160923_132613_create_PrestadoraTemp extends Migration
{
    public function safeUp()
    {
        $this->createTable('PrestadoraTemp', [
            'id' => Schema::TYPE_PK,
            'nro_afiliado' => Schema::TYPE_STRING . "(45) NULL",  
            'Prestadora_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'tanda' => Schema::TYPE_STRING . "(45) NULL",  
        ], $this->tableOptions);
    }

    public function safeDown()
    {
        $this->delete('PrestadoraTemp');
        $this->dropTable('PrestadoraTemp');
    }
}
