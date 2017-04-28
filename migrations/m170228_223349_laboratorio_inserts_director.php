<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170228_223349_laboratorio_inserts_director extends Migration
{
    public function safeUp()
    {
                $this->update('Laboratorio', [
                                        'director_nombre'=>'Dr. Christian Hellmund',  
                                        'director_titulo'=>'Anatomia Patologica',  
                                        'director_matricula'=>'MP 114008 - MN 106264',  
            
                                    ],["id"=>'1'] 
                   );
        
    }

    public function safeDown()
    {
    }
}
