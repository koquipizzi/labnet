<?php

use yii\db\Migration;

class m171010_153817_textos_inserts extends Migration
{
    public function safeUp()
    {
        $this->truncateTable('Textos');

        $textos = file_get_contents('migrations/autotextos.sql');

        $i=0;
        $key = 'INSERT INTO';
        $key_len = strlen($key);
        $textos .= $key;

        while(strlen($textos)>0) {
            $i++;
            $sql = trim(substr($textos,0,strpos($textos,$key)));
            $textos = substr($textos,strpos($textos,$key)+$key_len);

            if($sql!=='') {
                $this->execute($key." ".
                    str_replace("\\n","\n",
                    str_replace("\'","'",
                        addslashes($sql)
                    )
                    )
                );
            }
            if($i>50000) {
                die('error - Salio porque Nunca Termina');
            }
        }
    }

    public function safeDown()
    {
        $this->truncateTable('Textos'); 
    }

}
