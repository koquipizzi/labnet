<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Informe;
use app\models\Medico;
use app\models\Nomenclador;
use app\models\PacientePrestadora;
use app\models\Prestadoras;
use app\models\Protocolo;
use app\models\Tarifas;
use app\models\TipoDocumento;
use app\models\TipoPrestadora;
use yii\console\Controller;
use app\models\Cliente;
use app\models\Material;
use app\models\TipoPaquete;
use app\models\DetallePedido;
use app\models\Pieza;
use app\models\Pedido;
use app\models\Transporte;
use app\models\Paciente;
use app\models\Especialidad;
use app\models\Localidad;
use app\models\Procedencia;
use yii\validators\EmailValidator;

use \date;

use Yii;
use yii\db\Exception;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SyncProductionDatabaseController extends Controller
{

private function migrarPaciente($conn) {
    $validatorEmail = new EmailValidator();
    $nombre="";
    $transaction = Yii::$app->db->beginTransaction();
    try {
        $modelLocalidad = Localidad::find()->where(["nombre" => 'Indefinida'])->one();
        if (empty($modelLocalidad)) {
            $modelLocalidad = new Localidad();
            $modelLocalidad->nombre = 'Indefinida';
            $modelLocalidad->cp = '0000';
            if (!$modelLocalidad->save()) {
                $error=$modelLocalidad->getErrors();
                throw new \yii\base\Exception("Error, al salvar el model Localidad".$error);
            }
        }
        $pacientes = $conn->createCommand("SELECT * FROM mig_paciente ")->queryAll();
        foreach ($pacientes as $key => $value) {
            $modelPrestadoras = Prestadoras::find()->where(["id_old" => $value["Cobertura"]])->one();
            if (empty($modelPrestadoras)) {
                throw new \yii\base\Exception("Error, prestadora no found where id_old = {$value["Cobertura"]}. ");
            }

            echo "\n";
            $modelPaciente = new Paciente();
            $modelPaciente->nombre              = !empty($value["Nombre"]) ? utf8_encode($value["Nombre"]):" ";
            $modelPaciente->nro_documento       = !empty($value["nroDocto"]) ? utf8_encode($value["nroDocto"]) : 00000000;
            $modelPaciente->sexo                = $value["Sexo"];
            $modelPaciente->fecha_nacimiento    = !empty($value["fNacimiento"]) ? $value["fNacimiento"] : date('Y-m-d');
            $modelPaciente->email               =  $validatorEmail->validate( $value["Domicilio"],$error) ? utf8_encode($value["Domicilio"]): "";//la tabla paciente del esquema Hellmund tine los emails en la columna domicilio
            $modelPaciente->telefono            =  utf8_encode($value["telefono"]);
            $modelPaciente->id_old              =  $value["numero"];
            if(empty($modelPaciente->nombre)){
                $modelPaciente->nombre="Sin nombre";
            }
            $modelTipoDocumento = TipoDocumento::find()->where(["descripcion" => $value["tipoDocto"]])->one();
            if (!empty($modelTipoDocumento)) {
                $modelPaciente->Tipo_documento_id = $modelTipoDocumento->id;
            }{
                $modelTipoDocumentoIndefinido = TipoDocumento::find()->where(["descripcion" =>'Indefinido'])->one();
                if(empty($modelTipoDocumentoIndefinido)){
                    $modelTipoDocumentoIndefinido= new TipoDocumento();
                    $modelTipoDocumentoIndefinido->descripcion="Indefinido";
                    $modelTipoDocumentoIndefinido->save();
                }
                $modelPaciente->Tipo_documento_id = $modelTipoDocumentoIndefinido->id;
            }

            //atributos que van por default
            $modelPaciente->Localidad_id = $modelLocalidad->id;
            if (!$modelPaciente->save()) {
                $error=$modelPaciente->getErrors();
                var_dump($error);
                throw new    \yii\base\Exception("fallo al salvar el model paciente");
            }
            $modelPacientePrestadora                 = new PacientePrestadora();
            $modelPacientePrestadora->Paciente_id    = $modelPaciente->id;
            $modelPacientePrestadora->Prestadoras_id = $modelPrestadoras->id;
            $modelPacientePrestadora->nro_afiliado   = $value["Afiliado"];
            if (!$modelPacientePrestadora->save()) {
                $error=$modelPacientePrestadora->getErrors();
                throw new \yii\base\Exception("fallo al salvar el model paciente".$error);
            }
            var_dump($modelPaciente->nombre);
          echo   !empty($value["Nombre"]) ? $value["Nombre"]:" sin nombre ";
        }
        $transaction->commit();
    } catch (Exception $e) {
        $transaction->rollBack();
        echo "fallo al migrar pacientes".$e;
        return 0;
    }
    echo "finalizo Paciente\n";
    return 1;
}


    private function migrarProtocolo($conn) {
        $protocolo = $conn->createCommand("
          SELECT *
          FROM  Protocolos
        ")->queryAll();


        foreach ($protocolo as $key => $value) {

            $modelProtocolo= new Protocolo();
            $modelProtocolo->anio          = $value["Año"];
            $modelProtocolo->letra         = utf8_encode($value["Letra"]);
            $modelProtocolo->nro_secuencia = $value["Protocolo"];
            $modelProtocolo->fecha_entrada = $value["fEntrada"];
            $modelProtocolo->fecha_entrega = $value["fEntrega"];

            $modelPaciente = Paciente::find()->where(["old_id"=>$value["Paciente"]])->one();
            $modelPrestadora= Prestadora::find()->where(["old_id"=>$value["Cobertura"]])->one();
            $modelPacientePrestadora = PacientePrestadora::find()->where(["Paciente_id"=>$modelPaciente->id,"Prestadoras_id"=>$modelPaciente->id])->one();
            $modelProtocolo->Paciente_prestadora_id = $modelPacientePrestadora->id;
            $modelProtocolo->id_old        = $value["Numero"];

            if(!$modelProtocolo->save()){
                var_dump(($modelProtocolo->getErrors()));
                echo "fallo al salvar el model Medico";
                return 0;
            }
        }
    }

    private function migrarPap($conn) {
        $validatorEmail = new EmailValidator();
        $informes = $conn->createCommand("
        SELECT *
        FROM Estudios 
        where TipoEstudio=1 ")->queryAll();

        foreach ($informes as $key => $value) {
            $modelProtocolo= Protocolo::find(["id_old"=>$value["Protocolo"]])->where()->one();
            if(empty($modelProtocolo)){
                throw new \yii\base\Exception("Error, al obtener el model protocolo");
            }
            $leucositos=$value["Leucositos"];
            $hematies=$value["Hematies"];
            $leuco=0;
            $hemati=0;
            switch ($leucositos) {
                case "+":
                    $leuco=1;
                    break;
                case "++":
                    $leuco=2;
                    break;
                case "+++":
                    $leuco=3;
                    break;
                case "++++":
                    $leuco=4;
                    break;
            }
            switch ($hematies) {
                case "+":
                    $hemati=1;
                    break;
                case "++":
                    $hemati=2;
                    break;
                case "+++":
                    $hemati=3;
                    break;
                case "++++":
                    $hemati=4;
                    break;
            }

            $modelInforme= new Informe();
            $modelInforme->Protocolo_id     = $modelProtocolo->id;
            $modelInforme->observaciones    = $value["Comentario"];
            $modelInforme->material         = $value["Material"];
            $modelInforme->tecnica          = $value["Tecnica"];
            $modelInforme->micro            = $value["Micro"];
            $modelInforme->diagnostico      = $value["Diagnostico"];
            $modelInforme->obrservaciones   = $value["Diagnostico"];
            $modelInforme->leucositos       = $leuco;
            $modelInforme->hematies         = $hemati;
            $modelInforme->flora            = $value["Flora"];
            $modelInforme->otros            = $value["Otros"];
            $modelInforme->aspecto          = $value["Aspecto"];
            $modelInforme->calidad          = $value["Calidad"];
            $modelInforme->Estudio_id=1;

            if(!$modelInforme->save()){
                var_dump(($modelInforme->getErrors()));
                echo "fallo al salvar el model Medico";
                return 0;
            }
        }
    }


    private function migrarMedico($conn) {
    $validatorEmail = new EmailValidator();
    $medicos = $conn->createCommand("
        SELECT 
            Codigo
            ,Nombre
            ,eMail
            ,Domicilio
            ,Usuario
            ,Especialidad 
            ,telefono
        FROM mig_medicos ")->queryAll();

    $modelLocalidad= Localidad::find()->where(["nombre"=>'Indefinida'])->one();
    if(empty($modelLocalidad)){
        $modelLocalidad= new Localidad();
        $modelLocalidad->nombre='Indefinida';
        $modelLocalidad->cp='0000';
        if(!$modelLocalidad->save()){
            var_dump(($modelLocalidad->getErrors()));
        }
    }

    foreach ($medicos as $key => $value) {

        $modelMedico= new Medico();
        $modelMedico->nombre        = !empty($value["Nombre"])? utf8_encode($value["Nombre"]) : "sin nombre";
        $modelMedico->email         = $validatorEmail->validate($value["eMail"],$error) ? utf8_encode($value["eMail"]): "";
        $modelMedico->domicilio     = utf8_encode($value["Domicilio"]);
        $modelMedico->Localidad_id  = $modelLocalidad->id;
        $modelMedico->telefono      = $value["telefono"];
        if(array_key_exists("Especialidad",$value) and !empty($value["Especialidad"])){
            $modelEspecialidad= Especialidad::find()->where(["nombre"=>$value["Especialidad"]])->one();
            if(!empty($modelEspecialidad)){
                $modelMedico->especialidad_id=$modelEspecialidad->id;
            }
        }
        if(!$modelMedico->save()){
            var_dump(($modelMedico->getErrors()));
            echo "fallo al salvar el model Medico";
            return 0;
        }
    }
        echo "finalizo Medico\n";
        return 1;
    }


    private function migrarEspecialidad($conn) {
        $especialidad = $conn->createCommand("SELECT * FROM Medicos ")->queryAll();
        foreach ($especialidad as $key => $value) {
            $modelEspecialidad= Especialidad::find()->where(["nombre"=>$value["Especialidad"]])->one();
            if(empty( $modelEspecialidad) && !empty($value["Especialidad"]) ){
                $newModelEspecialidad= new Especialidad();
                $newModelEspecialidad->nombre=utf8_encode($value["Especialidad"]);
                if(!$newModelEspecialidad->save()){
                    var_dump(($newModelEspecialidad->getErrors()));
                    echo "fallo al salvar el model Especialidad";
                    return 0;
                }
            }


        }
        echo "finalizo Especialidad\n";

        return 1;
    }

    private function migrarProcedencia($conn) {
        $validatorEmail = new EmailValidator();
        $modelLocalidad= Localidad::find()->where(["nombre"=>'Indefinida'])->one();
        if(empty($modelLocalidad)){
            $modelLocalidad= new Localidad();
            $modelLocalidad->nombre='Indefinida';
            $modelLocalidad->cp='0000';
            if(!$modelLocalidad->save()){
                var_dump(($modelLocalidad->getErrors()));
            }
        }
        $procedencias = $conn->createCommand("SELECT * from mig_procedencia ")->queryAll();
        foreach ($procedencias as $key => $value) {
                $modelProcedencia= new Procedencia();
                $modelProcedencia->descripcion  = utf8_encode($value["Nombre"]);
                $modelProcedencia->domicilio    = utf8_encode($value["Domicilio"]);
                $modelProcedencia->mail         = $validatorEmail->validate( $value["eMail"],$error) ? utf8_encode($value["eMail"]): "";
                $modelProcedencia->id_old       = $value["Codigo"];
                $modelProcedencia->telefono     = utf8_encode($value["telefono"]);
                //atributos que van por default
                $modelProcedencia->Localidad_id=$modelLocalidad->id;

                if(!$modelProcedencia->save()){
                    var_dump(($modelProcedencia->getErrors()));
                    echo "fallo al salvar el model Procedencia\n";
                    return 0;
                }
        }
        echo "finalizo procedencia\n";
        return 1;
    }


// en el squema nuevo prestadora hace referencia a coberturas
    private function migrarCobertura($conn) {
        $validatorEmail = new EmailValidator();
        $modelLocalidad= Localidad::find()->where(["nombre"=>'Indefinida'])->one();
        if(empty($modelLocalidad)){
            $modelLocalidad= new Localidad();
            $modelLocalidad->nombre='Indefinida';
            $modelLocalidad->cp='0000';
            if(!$modelLocalidad->save()){
                var_dump(($modelLocalidad->getErrors()));
            }
        }
        $modelTipoPrestadora= TipoPrestadora::find()->where(["descripcion"=>'Indefinida'])->one();
        if(empty($modelTipoPrestadora)){
            $modelTipoPrestadora= new TipoPrestadora();
            $modelTipoPrestadora->descripcion='Indefinida';
            if(!$modelTipoPrestadora->save()){
                var_dump(($modelTipoPrestadora->getErrors()));
            }
        }
        $procedencias = $conn->createCommand("SELECT Codigo,Nombre,eMail,Domicilio,Telefonos FROM Cobertura ")->queryAll();
        foreach ($procedencias as $key => $value) {
            $modelPrestadora= new Prestadoras();
            $modelPrestadora->descripcion           = utf8_encode($value["Nombre"]);
            $modelPrestadora->domicilio             = utf8_encode($value["Domicilio"]);
            $modelPrestadora->telefono              = $value["Telefonos"];
            $modelPrestadora->email                 = $validatorEmail->validate( $value["eMail"],$error) ? utf8_encode($value["eMail"]): "";
            $modelPrestadora->cobertura             = 1;//por defecto son coberturas
            $modelPrestadora->id_old                = $value["Codigo"];
            //atributos que van por default
            $modelPrestadora->Localidad_id=$modelLocalidad->id;
            $modelPrestadora->Tipo_prestadora_id    =  $modelTipoPrestadora->id;
            if(!$modelPrestadora->save()){
                var_dump(($modelPrestadora->getErrors()));
                echo "fallo al salvar el model Procedencia\n";
                return 0;
            }
        }
        echo "finalizo Prestadora\n";
        return 1;
    }


    private function migrarNomenclador($conn) {
        $nomencladores = $conn->createCommand("SELECT Servicio,Nombre,Valor,Coseguro FROM NomencladorNacional ")->queryAll();
        foreach ($nomencladores as $key => $value) {
            $modelNomenclador= new Nomenclador();
            $modelNomenclador->servicio        = $value["Servicio"];
            $modelNomenclador->descripcion     = utf8_encode($value["Nombre"]);
            $modelNomenclador->valor           = $value["Valor"];
            $modelNomenclador->coseguro        = $value["Coseguro"];

            if(!$modelNomenclador->save()){
                var_dump(($modelNomenclador->getErrors()));
                echo "fallo al salvar el model Nomenclador\n";
                return 0;
            }
        }
        echo "finalizo Nomenclador\n";
        return 1;
    }

// en el squema nuevo prestadora hace referencia a coberturas
    private function migrarTarifa($conn) {
        $tarifas = $conn->createCommand("SELECT Procedencia,Cobertura,Nomenclador,Coeficiente,Valor,Coseguro FROM Tarifas ")->queryAll();
        foreach ($tarifas as $key => $value) {
            $modelTarifas= new Tarifas();
            $modelTarifas->valor           = $value["Valor"];
            $modelTarifas->coseguro        = $value["Coseguro"];

            $modelProcedencia= Procedencia::find()->where(["id_old"=>$value["Procedencia"]])->one();
            if(!empty($modelProcedencia)){
                $modelTarifas->Procedencia_id=$modelProcedencia->id;
            }

            $modelPrestadoras= Prestadoras::find()->where(["id_old"=>$value["Cobertura"]])->one();
            if(!empty($modelPrestadoras)){
                $modelTarifas->Prestadoras_id=$modelPrestadoras->id;
            }
            $modelNomenclador= Nomenclador::find()->where(["servicio"=>$value["Nomenclador"]])->one();
            if(!empty($modelNomenclador)){
                $modelTarifas->Nomenclador_id=$modelNomenclador->id;
            }

            if(!$modelTarifas->save()){
                var_dump(($modelTarifas->getErrors()));
                echo "fallo al salvar el model Tarifa\n";
                return 0;
            }
        }
        echo "finalizo Tarifas\n";
        return 1;
    }


    private function addColumsOldId($conecctionNewEsquema)
    {
        $conecctionNewEsquema->createCommand("       
            AlTER TABLE Procedencia add id_old INT(11);        
            AlTER TABLE Prestadoras add id_old INT(11);
            AlTER TABLE Paciente add id_old INT(11);
            AlTER TABLE Protocolo add id_old INT(11);
        ")->execute();
        echo "Se agregaron las columnas id_old a las entidades\n";
    }

    private function removeColumsOldId($conecctionNewEsquema)
    {
        $conecctionNewEsquema->createCommand("       
            AlTER TABLE Procedencia drop id_old;        
            AlTER TABLE Prestadoras drop id_old;
            AlTER TABLE Paciente   drop id_old;
            AlTER TABLE Protocolo   drop id_old;
        ")->execute();;
        echo "Se eliminaro las columnas id_old de las entidades\n";
    }

    private function  clearAllDatabase()
    {
        Tarifas::deleteAll();
        PacientePrestadora::deleteAll();
        Paciente::deleteAll();
        Prestadoras::deleteAll();
        Procedencia::deleteAll();
        Nomenclador::deleteAll();
        Medico::deleteAll();
        Especialidad::deleteAll();
        echo "Se han borrado todos los datos\n";
    }

    public function getDb() {
        return Yii::$app->dbMysqlServerDedicado;
    }
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionSync()
    {
        //$connection = \Yii::$app->dbSqlServer;
        $connection = \Yii::$app->dbSqlServerEmpresa;
        // $conecctionNewEsquema = \Yii::$app->dbMysqlServerDedicado;
        $conecctionNewEsquema = \Yii::$app->db;

        //$this->removeColumsOldId($conecctionNewEsquema);
        //prepara la base
        $this->addColumsOldId($conecctionNewEsquema);
        $this->clearAllDatabase();

        //comienza a migrar los datos de las entidades
        $this->migrarNomenclador($connection);
        $this->migrarEspecialidad($connection);
        $this->migrarMedico($connection);
        $this->migrarCobertura($connection);
        $this->migrarPaciente($connection);
        $this->migrarProcedencia($connection);
        $this->migrarTarifa($connection);

        //elimina de las entidades las fk id_old
        $this->removeColumsOldId($conecctionNewEsquema);
    }
    




















}
