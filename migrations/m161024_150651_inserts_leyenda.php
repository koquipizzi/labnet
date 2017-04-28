<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m161024_150651_inserts_leyenda extends Migration
{
	public function safeUp()
	{
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'A','texto'=>'Atrofico']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'AM','texto'=>'Atrofico (Menopausia).']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'ANE','texto'=>'(Evaluacion no alcanzada, segun cobertura).']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'H','texto'=>'Hipotrofico.']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'HM','texto'=>'Hipotrofico (Menopausia).']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'OL','texto'=>'Trofismo no evaluable por oligocelularidad.']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'T','texto'=>'Trofico / Estado madurativo conservado / Aspecto indeterminado.']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'TD','texto'=>'Trofico debil / Bajo indice madurativo.']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'TEA','texto'=>'Trofico / Extendido gravidico alterado (Alto indice cariopicnotico).']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'TEN','texto'=>'Trofico / Extendido gravidico normal (Bajo indice cariopicnotico).']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'THR','texto'=>'Trofico / Estado madurativo conservado (THR).']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'TI','texto'=>'Trofismo no evaluable.']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'TP','texto'=>'Trofico / Bajo agrupamiento y plegamiento celular / Alto indice cariopicnotico.']);
		$this->insert('Leyenda', ['categoria'=>'A', 'codigo'=>'TS','texto'=>'Trofico / Alto agrupamiento y plegamiento celular / Bajo indice cariopicnotico.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'A','texto'=>'Muestra apta para diagnostico.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'FF','texto'=>'Muestra limitada para diagnostico (Se recibe frotis fragmentado).']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'LA','texto'=>'Muestra limitada por fenomenos artefactuales.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'LH','texto'=>'Muestra limitada por hemorragia.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'LI','texto'=>'Muestra limitada por inflamacion.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'LIH','texto'=>'Muestra limitada por inflamacion y hemorragia.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'LO','texto'=>'Muestra limitada por oligocelularidad.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'NA','texto'=>'Muestra poco apta para diagnostico.']);
		$this->insert('Leyenda', ['categoria'=>'C', 'codigo'=>'SA','texto'=>'Muestra limitada por amplios sectores de aglutinamiento y superposicion celular']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'FB','texto'=>'Microbiota de predominio bacilar.']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'FC','texto'=>'Microbiota alterada con predomino cocoide.']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'FD','texto'=>'Microbiota conservada de predominio Doderleim.']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'FG','texto'=>'Alteracion de la microbiota vaginal / Bacterias.']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'FL','texto'=>'Microbiota conservada de predominio bacilar-lactobacilar.']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'FNE','texto'=>'(Evaluacion no alcanzada, segun cobertura).']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'PS','texto'=>'Microbiota poco significativa.']);
		$this->insert('Leyenda', ['categoria'=>'F', 'codigo'=>'SCB','texto'=>'Microbiota alterada de aspecto coco-bacilar / Bacterias.']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'ACT','texto'=>'Bacterias de caracteristicas morfologicas compatibles con Actinomices.']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'CA','texto'=>'Presencia de elementos micoticos de morfologia compatible con Candida.']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'G','texto'=>'Compatible con GAMM']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'LE','texto'=>'Presencia de eventuales estructuras micoticas levaduriformes en grupos.']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'ML','texto'=>'Ocasionales y dispersas estructuras micoticas fragmentadas.']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'NO','texto'=>'No se identifican microorganismos patogenos especificos.']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'TI','texto'=>'Presencia de Tricomona Vaginalis.']);
		$this->insert('Leyenda', ['categoria'=>'M', 'codigo'=>'TR','texto'=>'Presencia de elementos necrobioticos sospechosos, no concluyentes de Trich vag. Confirmar.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'AI','texto'=>'Presencia de estructuras bacterianas sugestivas de Actinomices I. Confirmar.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'CA','texto'=>'Elementos micoticos de morfologia compatible con Candida.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'CI','texto'=>'Marcada citolisis. Ocasionales histiocitos.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'CIT','texto'=>'Extendido con fondo intensamente citolitico.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'CT','texto'=>'Marcada citolisis. Elementos necrobioticos sospechosos de Trich vag.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'D','texto'=>'Extendido con fondo minimamente citolitico.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'DC','texto'=>'Discreta citolisis. No observo microorganismos patogenos especificos.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'HM','texto'=>'Presencia de histiocitos dispersos, algunos multinucleados.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'LEP','texto'=>'Se observan estructuras filiformes, sugestivas de Leptotrix.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'MC','texto'=>'Marcada citolisis. No observo microorganismos patogenos especificos.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'MOC','texto'=>'Extendido con fondo moderadamente citolitico.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'NC','texto'=>'Extensa citolisis, detritus celulares y nucleos desnudos.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'OML','texto'=>'Marcada citolisis. Ocasionales monilias lisadas.']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'ONE','texto'=>'(Evaluacion no alcanzada, segun cobertura).']);
		$this->insert('Leyenda', ['categoria'=>'O', 'codigo'=>'TV','texto'=>'Presencia de Tricomona Vaginalis.']);
	
	}
	
	public function safeDown()
	{
		$this->truncateTable('Leyenda');
	}
}



