<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Medico;
use app\models\Nomenclador;
use app\models\PacientePrestadora;
use app\models\Prestadoras;
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
        $pacientes = $conn->createCommand("SELECT  Nombre,nroDocto,Sexo,fNacimiento,Domicilio,tipoDocto,Cobertura,Afiliado FROM Pacientes ")->queryAll();
        foreach ($pacientes as $key => $value) {
            $modelPrestadoras = Prestadoras::find()->where(["id_old" => $value["Cobertura"]])->one();
            if (empty($modelPrestadoras)) {
                throw new \yii\base\Exception("Error, prestadora no found where id_old = {$value["Cobertura"]}. ");
            }
            $modelPaciente = new Paciente();
            $modelPaciente->nombre              = !empty($value["Nombre"]) ? $value["Nombre"] : "sin nombre";
            $modelPaciente->nro_documento       = !empty($value["nroDocto"]) ? $value["nroDocto"] : 00000000;
            $modelPaciente->sexo                = $value["Sexo"];
            $modelPaciente->fecha_nacimiento    = !empty($value["fNacimiento"]) ? $value["fNacimiento"] : date('Y-m-d');
            $modelPaciente->email               = $value["Domicilio"];//la tabla paciente del esquema Hellmund tine los emails en la columna domicilio
            //$modelPaciente->telefono=$value["Teléfono"];
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
                throw new \yii\base\Exception("fallo al salvar el model paciente".$error);
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
        }
        $transaction->commit();
    } catch (Exception $e) {
        $transaction->rollBack();
        echo "fallo al migrar pacientes".$e;
        return 0;
    }
    echo "finalizo Paciente";
    return 1;
}



    private function migrarMedico($conn) {

        $medicos = $conn->createCommand("
            SELECT 
                Codigo
                ,Nombre
                ,eMail
                ,Domicilio
                ,Usuario
                ,Especialidad 
            FROM Medicos ")->queryAll();
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
            $modelMedico->nombre=!empty($value["Nombre"])? $value["Nombre"] : "sin nombre";
            $modelMedico->email=$value["eMail"];
            $modelMedico->domicilio=$value["Domicilio"];
            $modelMedico->Localidad_id=$modelLocalidad->id;
            //$modelPaciente->telefono=$value["Teléfono"];
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
        echo "finalizo Medico";
        return 1;
    }


    private function migrarEspecialidad($conn) {
        $especialidad = $conn->createCommand("SELECT * FROM Medicos ")->queryAll();
        foreach ($especialidad as $key => $value) {
            $modelEspecialidad= Especialidad::find()->where(["nombre"=>$value["Especialidad"]])->one();
            if(empty( $modelEspecialidad) && !empty($value["Especialidad"]) ){
                $newModelEspecialidad= new Especialidad();
                $newModelEspecialidad->nombre=$value["Especialidad"];
                if(!$newModelEspecialidad->save()){
                    var_dump(($newModelEspecialidad->getErrors()));
                    echo "fallo al salvar el model Especialidad";
                    return 0;
                }
            }


        }
        echo "finalizo Especialidad";

        return 1;
    }

    private function migrarProcedencia($conn) {
        $modelLocalidad= Localidad::find()->where(["nombre"=>'Indefinida'])->one();
        if(empty($modelLocalidad)){
            $modelLocalidad= new Localidad();
            $modelLocalidad->nombre='Indefinida';
            $modelLocalidad->cp='0000';
            if(!$modelLocalidad->save()){
                var_dump(($modelLocalidad->getErrors()));
            }
        }
        $procedencias = $conn->createCommand("SELECT Codigo,Nombre,eMail,Domicilio,Usuario FROM Procedencia ")->queryAll();
        foreach ($procedencias as $key => $value) {
                $modelProcedencia= new Procedencia();
                $modelProcedencia->descripcion  = $value["Nombre"];
                $modelProcedencia->domicilio    = $value["Domicilio"];
                $modelProcedencia->mail         = $value["eMail"];
                $modelProcedencia->id_old       = $value["Codigo"];
                //atributos que van por default
                $modelProcedencia->Localidad_id=$modelLocalidad->id;

                if(!$modelProcedencia->save()){
                    var_dump(($modelProcedencia->getErrors()));
                    echo "fallo al salvar el model Procedencia";
                    return 0;
                }
        }
        echo "finalizo procedencia";
        return 1;
    }



// en el squema nuevo prestadora hace referencia a coberturas
    private function migrarCobertura($conn) {
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
        $procedencias = $conn->createCommand("SELECT Codigo,Nombre,eMail,Domicilio FROM Cobertura ")->queryAll();
        foreach ($procedencias as $key => $value) {
            $modelPrestadora= new Prestadoras();
            $modelPrestadora->descripcion           = $value["Nombre"];
            $modelPrestadora->domicilio             = $value["Domicilio"];
            $modelPrestadora->email                 = $value["eMail"];
            $modelPrestadora->cobertura             = 1;//por defecto son coberturas
            $modelPrestadora->id_old                = $value["Codigo"];
            //atributos que van por default
            $modelPrestadora->Localidad_id=$modelLocalidad->id;
            $modelPrestadora->Tipo_prestadora_id    =  $modelTipoPrestadora->id;
            if(!$modelPrestadora->save()){
                var_dump(($modelPrestadora->getErrors()));
                echo "fallo al salvar el model Procedencia";
                return 0;
            }
        }
        echo "finalizo Prestadora";
        return 1;
    }


    private function migrarNomenclador($conn) {
        $nomencladores = $conn->createCommand("SELECT Servicio,Nombre,Valor,Coseguro FROM NomencladorNacional ")->queryAll();
        foreach ($nomencladores as $key => $value) {
            $modelNomenclador= new Nomenclador();
            $modelNomenclador->servicio        = $value["Servicio"];
            $modelNomenclador->descripcion     = $value["Nombre"];
            $modelNomenclador->valor           = $value["Valor"];
            $modelNomenclador->coseguro        = $value["Coseguro"];

            if(!$modelNomenclador->save()){
                var_dump(($modelNomenclador->getErrors()));
                echo "fallo al salvar el model Nomenclador";
                return 0;
            }
        }
        echo "finalizo Nomenclador";
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
                echo "fallo al salvar el model Tarifa";
                return 0;
            }
        }
        echo "finalizo Tarifas";
        return 1;
    }


    private function addColumsOldId($conecctionNewEsquema)
    {
        $conecctionNewEsquema->createCommand("       
            AlTER TABLE Procedencia add id_old INT(11);        
            AlTER TABLE Prestadoras add id_old INT(11);
        ")->execute();
        echo "Se agregaron las columnas id_old a las entidades\n";
    }

    private function removeColumsOldId($conecctionNewEsquema)
    {
        $conecctionNewEsquema->createCommand("       
            AlTER TABLE Procedencia drop id_old;        
            AlTER TABLE Prestadoras drop id_old;
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


    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionSync()
    {
        $connection = \Yii::$app->dbSqlServer;
        $conecctionNewEsquema = \Yii::$app->db;
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
