<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160921_194254_InformeNomenclador extends Migration
{
    public function safeUp()
    {

        $this->createTable('{{%InformeNomenclador}}', [
            'id' => Schema::TYPE_PK,
            'id_informe' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'id_nomenclador' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

        // add foreign key for table `Nomenclador`
        $this->addForeignKey(
            'fk_InformeNomenclador_Nomenclador',
            'InformeNomenclador',
            'id_nomenclador',
            'Nomenclador',
            'id',
            'CASCADE'
        );
        // add foreign key for table `Informe`
        $this->addForeignKey(
            'fk_InformeNomenclador_Informe',
            'InformeNomenclador',
            'id_informe',
            'Informe',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('InformeNomenclador');
    }
}
