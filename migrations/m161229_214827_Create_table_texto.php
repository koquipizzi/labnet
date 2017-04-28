<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161229_214827_Create_table_texto extends Migration
{
    public function safeUp()
    {
       		$this->execute("
                                    CREATE TABLE `Textos` (
                                        `id` int(11) NOT NULL AUTO_INCREMENT,
                                        `codigo` varchar(2048),  
                                        `material` text DEFAULT NULL,
                                        `tecnica` text  DEFAULT NULL,
                                        `macro` text DEFAULT NULL,
                                        `micro` text  DEFAULT NULL,
                                        `diagnos` text  DEFAULT NULL,
                                        `observ` text  DEFAULT NULL,
                                    PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

                                "); 
    }

    public function safeDown()
    {
        $this->dropTable("Textos");
        
    }
}
