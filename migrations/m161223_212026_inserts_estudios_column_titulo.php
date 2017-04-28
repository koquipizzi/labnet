<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161223_212026_inserts_estudios_column_titulo extends Migration
{
    public function safeUp()
    {
        $this->update("Estudio",['titulo'=>'ESTUDIO DE CITOLOGIA EXFOLIATIVA CERVICAL'],['nombre'=>'PAP']);
        $this->update("Estudio",['titulo'=>'ESTUDIO ANATOMOPATOLÓGICO'],['nombre'=>'BIOPSIA']);
        $this->update("Estudio",['titulo'=>'ESTUDIO DE BIOLOGÍA MODELCULAR'],['nombre'=>'MOLECULAR']);
        $this->update("Estudio",['titulo'=>'ESTUDIO DE CITOLOGÍA ESPECIAL'],['nombre'=>'CITOLOGÍA ESPECIAL']);

    }

    public function safeDown()
    {
    }
}
