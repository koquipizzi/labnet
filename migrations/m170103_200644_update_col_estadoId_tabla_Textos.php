<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170103_200644_update_col_estadoId_tabla_Textos extends Migration
{
    public function safeUp()
    {
        $this->execute("
            UPDATE Textos SET estudio_id = 1 
            where codigo like 'P%' and id > 0;
            UPDATE Textos SET estudio_id = 5 
            where codigo like 'I%' and id > 0;
            UPDATE Textos SET estudio_id = 3 
            where codigo like 'M%' and id > 0;
            UPDATE Textos SET estudio_id = 4 
            where codigo like 'C%' and id > 0;
            UPDATE Textos SET estudio_id = 2 
            where codigo like 'B%' and id > 0;
                                "); 
    }

    public function safeDown()
    {
        $this->execute("
            UPDATE Textos SET estudio_id = null;
                                "); 
    }
}
