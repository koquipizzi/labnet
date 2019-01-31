<?php

use yii\db\Migration;

/**
 * Class m181218_162300_set_columns_with_full_text_search
 */
class m181218_162300_set_columns_with_full_text_search extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(
            "
            CREATE INDEX PACIENTE_INDEX on Paciente(nombre,email);

            CREATE fulltext index MEDICO_INDEX on Medico(nombre,email);
            
            CREATE fulltext index INFORME_INDEX on Informe(material,tecnica,macroscopia,microscopia,diagnostico);
       
            "
       );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    
    }

}
