<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161117_192108_Estado_sort_estados extends Migration
{
    public function up()
    {

    	$this->delete('Workflow');
    	$this->delete('Estado');
    	$this->insert('Estado', ['descripcion' => 'Pendiente', 'id'=>'1','autoAsignado'=>'N' ]);
    	$this->insert('Estado', ['descripcion' => 'Descartado', 'id'=>'2','autoAsignado'=>'N'  ]);
    	$this->insert('Estado', ['descripcion' => 'En Proceso', 'id'=>'3','autoAsignado'=>'S' ]);
    	$this->insert('Estado', ['descripcion' => 'Pausado', 'id'=>'4' ,'autoAsignado'=>'N' ]);
    	$this->insert('Estado', ['descripcion' => 'Finalizado' , 'id'=>'5','autoAsignado'=>'N' ]);
    	$this->insert('Estado', ['descripcion' => 'Entregado' , 'id'=>'6' ,'autoAsignado'=>'N']);
    }

    public function safeDown()
    {
    	$this->delete('Workflow');
    	$this->delete('Estado');
    }
}
