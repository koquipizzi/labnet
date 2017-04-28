<?php

use yii\db\Schema;
use jamband\schemadump\Migration;
use app\models\Informe;

class m161020_145950_add_colums_to_table_informe extends Migration
{
    public function safeUp()
    {
    	
    	$this->addColumn('Informe','leucositos', $this->string('10'));
    	$this->addColumn('Informe','aspecto', $this->string('10'));
    	$this->addColumn('Informe','calidad', $this->string('10'));
    	$this->addColumn('Informe','otros', $this->string('50'));
    	$this->addColumn('Informe','flora', $this->string('10'));
    	$this->addColumn('Informe','hematies', $this->string('10'));
    
  
    	
    	
    }

    public function safeDown()
    {
    	$this->dropColumn('Informe','leucositos');
    	$this->dropColumn('Informe','aspecto');
    	$this->dropColumn('Informe','calidad');
    	$this->dropColumn('Informe','otros');
    	$this->dropColumn('Informe','flora');
    	$this->dropColumn('Informe','hematies');
   
    	
    }
}
