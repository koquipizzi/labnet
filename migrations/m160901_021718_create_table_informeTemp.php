<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160901_021718_create_table_informeTemp extends Migration
{
    public function safeUp()
    {
        	$this->createTable('{{%InformeTemp}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(255) NULL",
		    'observaciones' => Schema::TYPE_STRING . "(1024) NULL",
		    'material' => Schema::TYPE_STRING . "(1024) NULL",
		    'tecnica' => Schema::TYPE_STRING . "(1024) NULL",
		    'macroscopia' => Schema::TYPE_STRING . "(1024) NULL",
		    'microscopia' => Schema::TYPE_STRING . "(1024) NULL",
		    'diagnostico' => Schema::TYPE_STRING . "(1024) NULL",
		    'Informecol' => Schema::TYPE_STRING . "(45) NULL",
		    'Estudio_id' => Schema::TYPE_INTEGER . "(11) NULL",
		    'Protocolo_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

                $this->addColumn('InformeTemp','session_id', 'string');
                $this->addColumn('InformeTemp','create_date', 'timestamp');
                $this->addColumn('InformeTemp','tanda', 'string');
        
    }
    

    public function safeDown()
    {
        $this->dropTable('InformeTemp');
        
    }
}
