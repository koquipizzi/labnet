<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170119_173228_Drop_table_contable extends Migration
{
    public function safeUp()
    {
        $this->dropTable("Contable");
    }

    public function safeDown()
    {
            $this->execute("               
                                    CREATE TABLE `Contable` (
                                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                                  `paciente` varchar(2048),  
                                                  PRIMARY KEY (`id`)
                                            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;"
                        );
          
    }
}
