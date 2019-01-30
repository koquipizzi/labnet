<?php

use yii\db\Migration;

/**
 * Class m190130_174530_create_table_leyenda_categoria
 */
class m190130_174530_create_table_leyenda_categoria extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    { 
        $this->createTable('Leyenda_categoria', [
            'id' => $this->string(10)->notNull(),
            'descripcion' => $this->string()->notNull(),
        ]);
        $this->addPrimaryKey('Leyenda_categoria_pk', 'Leyenda_categoria', ['id']);
        $this->insert('Leyenda_categoria', ['id' => 'A', 'descripcion'=> 'A'] );
        $this->insert('Leyenda_categoria', ['id' => 'C', 'descripcion'=> 'C'] );
        $this->insert('Leyenda_categoria', ['id' => 'F', 'descripcion'=> 'F'] );
        $this->insert('Leyenda_categoria', ['id' => 'LH', 'descripcion'=> 'LH'] );
        $this->insert('Leyenda_categoria', ['id' => 'O', 'descripcion'=> 'O'] );
        $this->insert('Leyenda_categoria', ['id' => 'M', 'descripcion'=> 'M'] );
        $this->insert('Leyenda_categoria', ['id' => 'PAP', 'descripcion'=> 'PAP'] ); 

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->droptable("Leyenda_categoria");
    }

}
