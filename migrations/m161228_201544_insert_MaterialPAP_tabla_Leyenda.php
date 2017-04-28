<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161228_201544_insert_MaterialPAP_tabla_Leyenda extends Migration
{
    public function safeUp()
	{
		$this->insert('Leyenda', ['categoria'=>'PAP', 'codigo'=>'Material','texto'=>'Extendido cervico-vaginal (Citología exfoliativa oncológica y hormonal).
                        TECNICA CITOLOGICA:
                        Fijación el alcohol 96 y coloración de rutina con técnica de Papanicolaou.']);
	}
	
	public function safeDown()
	{
		$this->truncateTable('Leyenda');
	}
}
