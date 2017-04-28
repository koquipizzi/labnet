<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160920_023727_InformeNomencladorTemporal extends Migration
{
    public function safeUp()
    {

        $this->createTable('{{%InformeNomencladorTemporal}}', [
            'id' => Schema::TYPE_PK,
            'id_informeTemp' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'id_nomenclador' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

        // add foreign key for table `Nomenclador`
        $this->addForeignKey(
            'fk_InformeNomencladorTemporal_Nomenclador',
            'InformeNomencladorTemporal',
            'id_nomenclador',
            'Nomenclador',
            'id',
            'CASCADE'
        );
        // add foreign key for table `InformeTemp`
        $this->addForeignKey(
            'fk_InformeNomencladorTemporal_InformeTemp',
            'InformeNomencladorTemporal',
            'id_informeTemp',
            'InformeTemp',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('InformeNomencladorTemporal');
    }
}
