<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160817_034541_modeloInicialBD extends Migration
{
    public function safeUp()
    {

		    	// Estado
		$this->createTable('{{%Estado}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(45) NULL",
		], $this->tableOptions);

		// Estudio
		$this->createTable('{{%Estudio}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(255) NULL",
		    'nombre' => Schema::TYPE_STRING . "(45) NULL",
		    'titulo' => Schema::TYPE_STRING . "(45) NULL",
		    'columnas' => Schema::TYPE_STRING . "(255) NULL",
		    'template' => Schema::TYPE_STRING . "(4096) NULL",
		], $this->tableOptions);

		// Informe
		$this->createTable('{{%Informe}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(255) NULL",
		    'observaciones' => Schema::TYPE_STRING . "(1024) NULL",
		    'material' => Schema::TYPE_STRING . "(1024) NULL",
		    'tecnica' => Schema::TYPE_STRING . "(1024) NULL",
		    'macroscopia' => Schema::TYPE_STRING . "(1024) NULL",
		    'microscopia' => Schema::TYPE_STRING . "(1024) NULL",
		    'diagnostico' => Schema::TYPE_STRING . "(1024) NULL",
		    'Informecol' => Schema::TYPE_STRING . "(45) NULL",
		    'Estudio_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Protocolo_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);





		// Localidad
		$this->createTable('{{%Localidad}}', [
		    'id' => Schema::TYPE_PK,
		    'nombre' => Schema::TYPE_STRING . "(100) NULL",
		    'cp' => Schema::TYPE_STRING . "(10) NULL",
		], $this->tableOptions);

		// Medico
		$this->createTable('{{%Medico}}', [
		    'id' => Schema::TYPE_PK,
		    'nombre' => Schema::TYPE_STRING . "(100) NULL",
		    'email' => Schema::TYPE_STRING . "(30) NULL",
		    'especialidad' => Schema::TYPE_STRING . "(45) NULL",
		    'domicilio' => Schema::TYPE_STRING . "(45) NULL",
		    'telefono' => Schema::TYPE_STRING . "(15) NULL",
		    'Localidad_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

		// Nomenclador
		$this->createTable('{{%Nomenclador}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(45) NULL",
		    'valor' => Schema::TYPE_DECIMAL . "(8,2) NULL",
		    'Prestadoras_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

		// Paciente
		$this->createTable('{{%Paciente}}', [
		    'id' => Schema::TYPE_PK,
		    'nombre' => Schema::TYPE_STRING . "(150) NULL",
		    'nro_documento' => Schema::TYPE_STRING . "(10) NULL",
		    'sexo' => Schema::TYPE_STRING . "(1) NULL",
		    'fecha_nacimiento' => Schema::TYPE_DATE . " NULL",
		    'telefono' => Schema::TYPE_STRING . "(15) NULL",
		    'email' => Schema::TYPE_STRING . "(30) NULL",
		    'Tipo_documento_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Localidad_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'domicilio' => Schema::TYPE_STRING . "(45) NULL",
		], $this->tableOptions);

		// Paciente_prestadora
		$this->createTable('{{%Paciente_prestadora}}', [
		    'id' => Schema::TYPE_PK,
		    'nro_afiliado' => Schema::TYPE_STRING . "(45) NULL",
		    'Paciente_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Prestadoras_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

		// Prestadoras
		$this->createTable('{{%Prestadoras}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(45) NULL",
		    'telefono' => Schema::TYPE_STRING . "(15) NULL",
		    'domicilio' => Schema::TYPE_STRING . "(45) NULL",
		    'email' => Schema::TYPE_STRING . "(30) NULL",
		    'Localidad_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'facturable' => Schema::TYPE_CHAR . "(1) NULL DEFAULT 'N'",
		    'Tipo_prestadora_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

		// Procedencia
		$this->createTable('{{%Procedencia}}', [
		    'id' => Schema::TYPE_PK,
		    'descipcion' => Schema::TYPE_STRING . "(45) NULL",
		    'domicilio' => Schema::TYPE_STRING . "(45) NULL",
		    'Localidad_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

		// Protocolo
		$this->createTable('{{%Protocolo}}', [
		    'id' => Schema::TYPE_PK,
		    'fecha_entrada' => Schema::TYPE_DATE . " NULL",
		    'anio' => Schema::TYPE_STRING . "(4) NULL",
		    'letra' => Schema::TYPE_CHAR . "(1) NULL",
		    'nro_secuencia' => Schema::TYPE_INTEGER . "(11) NULL",
		    'registro' => Schema::TYPE_STRING . "(45) NULL",
		    'observaciones' => Schema::TYPE_STRING . "(255) NULL",
		    'Medico_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Procedencia_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Paciente_prestadora_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'FacturarA_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

		// Responsable
		$this->createTable('{{%Responsable}}', [
		    'id' => Schema::TYPE_PK,
		    'nombre' => Schema::TYPE_STRING . "(45) NULL",
		], $this->tableOptions);

		// Tarifas
		$this->createTable('{{%Tarifas}}', [
		    'id' => Schema::TYPE_PK,
		    'valor' => Schema::TYPE_DECIMAL . "(8,2) NULL",
		    'coseguro' => Schema::TYPE_DECIMAL . "(8,2) NULL",
		    'Procedencia_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Prestadoras_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Nomenclador_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);

		// Tipo_documento
		$this->createTable('{{%Tipo_documento}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(10) NULL",
		], $this->tableOptions);

		// Tipo_prestadora
		$this->createTable('{{%Tipo_prestadora}}', [
		    'id' => Schema::TYPE_PK,
		    'descripcion' => Schema::TYPE_STRING . "(45) NULL",
		], $this->tableOptions);

		// Workflow
		$this->createTable('{{%Workflow}}', [
		    'id' => Schema::TYPE_PK,
		    'fecha_inicio' => Schema::TYPE_DATE . " NULL",
		    'fecha_fin' => Schema::TYPE_DATE . " NULL",
		    'Estado_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Responsable_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		    'Informe_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
		], $this->tableOptions);


//modelo de addforeignkey
		//$this->addForeignKey('FK_post_author', 'tbl_post', 'author_id', 'tbl_user', 'id', $delete='CASCADE', $update='RESTRICT');
			//donde tanto delete como updete no se escriben


		// fk: Informe
		$this->addForeignKey('fk_Informe_Estudio_id', '{{%Informe}}', 'Estudio_id', '{{%Estudio}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Informe_Protocolo_id', '{{%Informe}}', 'Protocolo_id', '{{%Protocolo}}', 'id', ' NO ACTION',' NO ACTION');

// The ON DELETE option. Most DBMS support these options: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
// $update 	string 	

// The ON UPDATE option. Most DBMS support these options: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL


//  PRIMARY KEY (`id`),
//   KEY `fk_Informe_Estudio1_idx` (`Estudio_id`),
//   KEY `fk_Informe_Protocolo1_idx` (`Protocolo_id`),
//   CONSTRAINT `fk_Informe_Estudio1` FOREIGN KEY (`Estudio_id`) REFERENCES `Estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
//   CONSTRAINT `fk_Informe_Protocolo1` FOREIGN KEY (`Protocolo_id`) REFERENCES `Protocolo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
// /*!40101 SET character_set_client = @saved_cs_client */;

		// fk: Medico
		$this->addForeignKey('fk_Medico_Localidad_id', '{{%Medico}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');

		// fk: Nomenclador
		$this->addForeignKey('fk_Nomenclador_Prestadoras_id', '{{%Nomenclador}}', 'Prestadoras_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Paciente
		$this->addForeignKey('fk_Paciente_Localidad_id', '{{%Paciente}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Paciente_Tipo_documento_id', '{{%Paciente}}', 'Tipo_documento_id', '{{%Tipo_documento}}', 'id', ' NO ACTION',' NO ACTION');



		// fk: Paciente_prestadora
		$this->addForeignKey('fk_Paciente_prestadora_Paciente_id', '{{%Paciente_prestadora}}', 'Paciente_id', '{{%Paciente}}', 'id',' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Paciente_prestadora_Prestadoras_id', '{{%Paciente_prestadora}}', 'Prestadoras_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Prestadoras
		$this->addForeignKey('fk_Prestadoras_Localidad_id', '{{%Prestadoras}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Prestadoras_Tipo_prestadora_id', '{{%Prestadoras}}', 'Tipo_prestadora_id', '{{%Tipo_prestadora}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Procedencia
		$this->addForeignKey('fk_Procedencia_Localidad_id', '{{%Procedencia}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');



		// fk: Protocolo
		$this->addForeignKey('fk_Protocolo_Medico_id', '{{%Protocolo}}', 'Medico_id', '{{%Medico}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Protocolo_Paciente_prestadora_id', '{{%Protocolo}}', 'Paciente_prestadora_id', '{{%Paciente_prestadora}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Protocolo_FacturarA_id', '{{%Protocolo}}', 'FacturarA_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Protocolo_Procedencia_id', '{{%Protocolo}}', 'Procedencia_id', '{{%Procedencia}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Tarifas
		$this->addForeignKey('fk_Tarifas_Nomenclador_id', '{{%Tarifas}}', 'Nomenclador_id', '{{%Nomenclador}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Tarifas_Prestadoras_id', '{{%Tarifas}}', 'Prestadoras_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Tarifas_Procedencia_id', '{{%Tarifas}}', 'Procedencia_id', '{{%Procedencia}}', 'id', ' NO ACTION',' NO ACTION');

		// fk: Workflow
		$this->addForeignKey('fk_Workflow_Estado_id', '{{%Workflow}}', 'Estado_id', '{{%Estado}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Workflow_Informe_id', '{{%Workflow}}', 'Informe_id', '{{%Informe}}', 'id', ' NO ACTION',' NO ACTION');
		$this->addForeignKey('fk_Workflow_Responsable_id', '{{%Workflow}}', 'Responsable_id', '{{%Responsable}}', 'id', ' NO ACTION',' NO ACTION');


    }

    public function safeDown()
    {

		// fk: Informe
		$this->dropForeignKey('fk_Informe_Estudio_id', '{{%Informe}}', 'Estudio_id', '{{%Estudio}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Informe_Protocolo_id', '{{%Informe}}', 'Protocolo_id', '{{%Protocolo}}', 'id', ' NO ACTION',' NO ACTION');

// The ON DELETE option. Most DBMS support these options: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
// $update 	string 	

// The ON UPDATE option. Most DBMS support these options: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL


//  PRIMARY KEY (`id`),
//   KEY `fk_Informe_Estudio1_idx` (`Estudio_id`),
//   KEY `fk_Informe_Protocolo1_idx` (`Protocolo_id`),
//   CONSTRAINT `fk_Informe_Estudio1` FOREIGN KEY (`Estudio_id`) REFERENCES `Estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
//   CONSTRAINT `fk_Informe_Protocolo1` FOREIGN KEY (`Protocolo_id`) REFERENCES `Protocolo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
// /*!40101 SET character_set_client = @saved_cs_client */;

		// fk: Medico
		$this->dropForeignKey('fk_Medico_Localidad_id', '{{%Medico}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');

		// fk: Nomenclador
		$this->dropForeignKey('fk_Nomenclador_Prestadoras_id', '{{%Nomenclador}}', 'Prestadoras_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Paciente
		$this->dropForeignKey('fk_Paciente_Localidad_id', '{{%Paciente}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Paciente_Tipo_documento_id', '{{%Paciente}}', 'Tipo_documento_id', '{{%Tipo_documento}}', 'id', ' NO ACTION',' NO ACTION');



		// fk: Paciente_prestadora
		$this->dropForeignKey('fk_Paciente_prestadora_Paciente_id', '{{%Paciente_prestadora}}', 'Paciente_id', '{{%Paciente}}', 'id',' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Paciente_prestadora_Prestadoras_id', '{{%Paciente_prestadora}}', 'Prestadoras_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Prestadoras
		$this->dropForeignKey('fk_Prestadoras_Localidad_id', '{{%Prestadoras}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Prestadoras_Tipo_prestadora_id', '{{%Prestadoras}}', 'Tipo_prestadora_id', '{{%Tipo_prestadora}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Procedencia
		$this->dropForeignKey('fk_Procedencia_Localidad_id', '{{%Procedencia}}', 'Localidad_id', '{{%Localidad}}', 'id', ' NO ACTION',' NO ACTION');



		// fk: Protocolo
		$this->dropForeignKey('fk_Protocolo_Medico_id', '{{%Protocolo}}', 'Medico_id', '{{%Medico}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Protocolo_Paciente_prestadora_id', '{{%Protocolo}}', 'Paciente_prestadora_id', '{{%Paciente_prestadora}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Protocolo_FacturarA_id', '{{%Protocolo}}', 'FacturarA_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Protocolo_Procedencia_id', '{{%Protocolo}}', 'Procedencia_id', '{{%Procedencia}}', 'id', ' NO ACTION',' NO ACTION');


		// fk: Tarifas
		$this->dropForeignKey('fk_Tarifas_Nomenclador_id', '{{%Tarifas}}', 'Nomenclador_id', '{{%Nomenclador}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Tarifas_Prestadoras_id', '{{%Tarifas}}', 'Prestadoras_id', '{{%Prestadoras}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Tarifas_Procedencia_id', '{{%Tarifas}}', 'Procedencia_id', '{{%Procedencia}}', 'id', ' NO ACTION',' NO ACTION');

		// fk: Workflow
		$this->dropForeignKey('fk_Workflow_Estado_id', '{{%Workflow}}', 'Estado_id', '{{%Estado}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Workflow_Informe_id', '{{%Workflow}}', 'Informe_id', '{{%Informe}}', 'id', ' NO ACTION',' NO ACTION');
		$this->dropForeignKey('fk_Workflow_Responsable_id', '{{%Workflow}}', 'Responsable_id', '{{%Responsable}}', 'id', ' NO ACTION',' NO ACTION');

    	$this->dropTable('{{%Estado}}');
		$this->dropTable('{{%Estudio}}');
		$this->dropTable('{{%Informe}}'); // fk: Estudio_id, Protocolo_id
		$this->dropTable('{{%Localidad}}');
		$this->dropTable('{{%Medico}}'); // fk: Localidad_id
		$this->dropTable('{{%Nomenclador}}'); // fk: Prestadoras_id
		$this->dropTable('{{%Paciente}}'); // fk: Localidad_id, Tipo_documento_id
		$this->dropTable('{{%Paciente_prestadora}}'); // fk: Paciente_id, Prestadoras_id
		$this->dropTable('{{%Prestadoras}}'); // fk: Localidad_id, Tipo_prestadora_id
		$this->dropTable('{{%Procedencia}}'); // fk: Localidad_id
		$this->dropTable('{{%Protocolo}}'); // fk: FacturarA_id, Medico_id, Paciente_prestadora_id, Procedencia_id
		$this->dropTable('{{%Responsable}}');
		$this->dropTable('{{%Tarifas}}'); // fk: Nomenclador_id, Prestadoras_id, Procedencia_id
		$this->dropTable('{{%Tipo_documento}}');
		$this->dropTable('{{%Tipo_prestadora}}');
		$this->dropTable('{{%Workflow}}'); // fk: Estado_id, Informe_id, Responsable_id

    }
}
