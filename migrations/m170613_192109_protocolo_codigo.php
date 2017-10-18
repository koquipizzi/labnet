<?php

use yii\db\Migration;

class m170613_192109_protocolo_codigo extends Migration
{
    public function safeUp()
    {
        $this->execute('alter table Protocolo add codigo varchar(30)');
        $this->execute(" 
            CREATE TRIGGER bi_protocolo_codigo
                BEFORE INSERT ON Protocolo
                FOR EACH ROW
            BEGIN
                SET NEW.codigo = CONCAT(SUBSTRING(NEW.anio,-2),NEW.letra,'-', LPAD(NEW.nro_secuencia, 6, 0));
            END
        ");
        $this->execute(" 
            CREATE TRIGGER bu_protocolo_codigo
                BEFORE UPDATE ON Protocolo
                FOR EACH ROW
            BEGIN
                SET NEW.codigo = CONCAT(SUBSTRING(NEW.anio,-2),NEW.letra,'-', LPAD(NEW.nro_secuencia, 6, 0));
            END
        ");        
    }

    public function safeDown()
    {
        //echo "m170613_192109_protocolo_codigo cannot be reverted.\n";
        $this->execute('DROP TRIGGER IF EXISTS bi_protocolo_codigo');
        $this->execute('DROP TRIGGER IF EXISTS bu_protocolo_codigo');
        $this->execute('alter table Protocolo drop codigo');       
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170613_192109_protocolo_codigo cannot be reverted.\n";

        return false;
    }
    */
}
