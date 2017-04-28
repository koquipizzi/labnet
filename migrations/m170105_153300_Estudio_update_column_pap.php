<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m170105_153300_Estudio_update_column_pap extends Migration
{
    public function safeUp()
    {
                $this->update("Estudio",['titulo'=>'ESTUDIO DE CITOLOGIA EXFOLIATIVA (PAP)'],["nombre"=>'PAP']);
    }

    public function safeDown()
    {
    }
}
