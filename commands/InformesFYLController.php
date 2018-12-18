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
use app\models\Workflow;
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
class InformesFYLController extends Controller
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
            if($value["Cobertura"]==0){
                $modelPrestadoras = Prestadoras::find()->where(["id_old" => 1])->one();
                if (empty($modelPrestadoras)) {
                    throw new \yii\base\Exception("Error, prestadora no found where id_old = {$value["Cobertura"]}. ");
                }
            }else{
                $modelPrestadoras = Prestadoras::find()->where(["id_old" => $value["Cobertura"]])->one();
                if (empty($modelPrestadoras)) {
                    throw new \yii\base\Exception("Error, prestadora no found where id_old = {$value["Cobertura"]}. ");
                }
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
            FROM mig_protocolo
            where Letra='F' or Letra='L'
        ")->queryAll();
        foreach ($protocolo as $key => $value) {
            $modelProtocolo= new Protocolo();
            $modelProtocolo->anio          = strval($value["Anio"]);
            $modelProtocolo->letra         = utf8_encode($value["Letra"]);
            $modelProtocolo->nro_secuencia = $value["Protocolo"];
            $modelProtocolo->fecha_entrada = $value["fEntrada"];
            $modelProtocolo->fecha_entrega = $value["fEntrega"];
            $modelProtocolo->observaciones = utf8_encode($value["Observaciones"]);
            $modelProtocolo->id_old        = $value["Numero"];
            var_dump($modelProtocolo->id_old);
            /*************************************************************************/
            //obtener pacientePrestadora id a partir de la prestadora y el paciente
            $modelPaciente              = Paciente::find()->where(["id_old"=>$value["Paciente"]])->one();
            if($value["Cobertura"]==0){
                $modelPrestadora            = Prestadoras::find()->where(["id_old"=>1])->one();
            }else{
                $modelPrestadora            = Prestadoras::find()->where(["id_old"=>$value["Cobertura"]])->one();
            }

            $modelPacientePrestadora    = PacientePrestadora::find()->where(["Paciente_id"=>$modelPaciente->id,"Prestadoras_id"=>$modelPrestadora->id])->one();

            if(empty($modelPacientePrestadora) &&  !empty($modelPaciente)  && !empty($modelPrestadora)  ){
                $modelPacientePrestadora= NEW PacientePrestadora();
                $modelPacientePrestadora                 = new PacientePrestadora();
                $modelPacientePrestadora->Paciente_id    = $modelPaciente->id;
                $modelPacientePrestadora->Prestadoras_id = $modelPrestadora->id;
                $modelPacientePrestadora->nro_afiliado   = $value["Afiliado"];
                if (!$modelPacientePrestadora->save()) {
                    $error=$modelPacientePrestadora->getErrors();
                    throw new \yii\base\Exception("fallo al salvar el model paciente".$error);
                }
            }
            //set protocolo Paciente_prestadora_id
            $modelProtocolo->Paciente_prestadora_id = $modelPacientePrestadora->id;

            /*************************************************************************/
            //obtener el id del medico
            $modelMedico = Medico::find()->where(["id_old"=>$value["Medico"]])->one();
            $modelProtocolo->Medico_id=$modelMedico->id;
            /*************************************************************************/

            /*************************************************************************/
            //obtener el id de la procedencia
            $modelProcedencia = Procedencia::find()->where(["id_old"=>$value["Procedencia"]])->one();
            $modelProtocolo->Procedencia_id=$modelProcedencia->id;
            /*************************************************************************/

            /*************************************************************************/
            //obtener id de facturar_A
            $modelPrestadora= Prestadoras::find()->where(["id_old"=>$value["FacturarA"],"facturable"=>"S"])->one();
            if(empty($modelPrestadora)){
                var_dump($modelProtocolo->id_old);
                var_dump($value);
                echo "fact a ".$value["FacturarA"];
            }

            $modelProtocolo->FacturarA_id=$modelPrestadora->id;
            /*************************************************************************/

            if(!$modelProtocolo->save()){
                var_dump(($modelProtocolo->getErrors()));
                echo "fallo al salvar el model Medico";
                return 0;
            }
        }
        echo "finalizo Protocolo\n";
    }

    private function migrarPap($conn) {
        //$validatorEmail = new EmailValidator();
        $informes = $conn->createCommand("
          select * from mig_informe_pap
         ")->queryAll();
        foreach ($informes as $key => $value) {
            var_dump($value["Protocolo"]);
            $modelProtocolo= Protocolo::find()->where(["id_old"=>$value["Protocolo"]])->one();
     if(!empty($modelProtocolo)) {
         if (empty($modelProtocolo)) {
             throw new \yii\base\Exception("Error, al obtener el model protocolo");
         }
         $leucocitos = $value["Leucocitos"];
         $hematies = $value["Hematies"];
         $estado = $value["Estado"];
         $leuco = "0";
         $hemati = "0";
         $estadoFinal = 0;
         switch ($leucocitos) {
             case "+":
                 $leuco = "1";
                 break;
             case "++":
                 $leuco = "2";
                 break;
             case "+++":
                 $leuco = "3";
                 break;
             case "++++":
                 $leuco = "4";
                 break;
         }
         switch ($hematies) {
             case "+":
                 $hemati = "1";
                 break;
             case "++":
                 $hemati = "2";
                 break;
             case "+++":
                 $hemati = "3";
                 break;
             case "++++":
                 $hemati = "4";
                 break;
         }

         switch ($estado) {
             case 0:
                 $estadoFinal = 1;
                 break;
             case 1:
                 $estadoFinal = 3;
                 break;
             case 2:
                 $estadoFinal = 4;
                 break;
             case 4:
                 $estadoFinal = 5;
                 break;
             case 5:
                 $estadoFinal = 5;
                 break;
             case 6:
                 $estadoFinal = 6;
                 break;
         }

         $modelInforme = new Informe();
         $modelInforme->Protocolo_id = $modelProtocolo->id;
         $modelInforme->observaciones = utf8_encode($value["Comentario"]);
         $modelInforme->material = utf8_encode($value["Material"]);
         $modelInforme->tecnica = utf8_encode($value["Tecnica"]);
         $modelInforme->citologia = utf8_encode($value["Micro"]);
         $modelInforme->diagnostico = utf8_encode($value["Diagnostico"]);
         $modelInforme->leucositos = $leuco;
         $modelInforme->hematies = $hemati;
         $modelInforme->flora = $value["Flora"];
         $modelInforme->otros = $value["Otros"];
         $modelInforme->aspecto = $value["Aspecto"];
         $modelInforme->calidad = $value["Calidad"];
         $modelInforme->Estudio_id = 1;//pap
         $modelInforme->estado_actual = $estadoFinal;

         var_dump($modelProtocolo->id);
         if (!$modelInforme->save()) {
             var_dump(($modelInforme->getErrors()));
             echo "fallo al salvar el model Informe Pap ";
             return 0;
         }


         $modelWorkflow = new Workflow();
         $modelWorkflow->Informe_id = $modelInforme->id;
         $modelWorkflow->Estado_id = $estadoFinal;
         $modelWorkflow->Responsable_id= 5; //christian
         if (!$modelWorkflow->save()) {
             var_dump(($modelWorkflow->getErrors()));
             echo "fallo al salvar el model  Workflow ";
             return 0;
         }
     }
        }
        echo "Finalizo Informe Pap\n";
        return 1;
    }

    private function migrarBiopcia($conn) {
        $validatorEmail = new EmailValidator();
        $informes = $conn->createCommand("
            SELECT *
            FROM mig_informe_biopcia 
         ")->queryAll();

        foreach ($informes as $key => $value) {
            var_dump($value["Protocolo"]);
            $modelProtocolo = Protocolo::find()->where(["id_old" => $value["Protocolo"]])->one();
        if(!empty($modelProtocolo)) {
            if (empty($modelProtocolo)) {
                throw new \yii\base\Exception("Error, al obtener el model protocolo");
            }

            $estado = $value["Estado"];
            $estadoFinal = 0;
            switch ($estado) {
                case 0:
                    $estadoFinal = 1;
                    break;
                case 1:
                    $estadoFinal = 3;
                    break;
                case 2:
                    $estadoFinal = 4;
                    break;
                case 4:
                    $estadoFinal = 5;
                    break;
                case 5:
                    $estadoFinal = 5;
                    break;
                case 6:
                    $estadoFinal = 6;
                    break;
            }


            $modelInforme = new Informe();
            $modelInforme->Protocolo_id = $modelProtocolo->id;
            $modelInforme->observaciones = utf8_encode($value["Comentario"]);
            $modelInforme->material = utf8_encode($value["Material"]);
            $modelInforme->tecnica = utf8_encode($value["Tecnica"]);
            $modelInforme->microscopia = utf8_encode($value["Micro"]);
            $modelInforme->macroscopia = utf8_encode($value["Macro"]);
            $modelInforme->diagnostico = utf8_encode($value["Diagnostico"]);
            $modelInforme->Estudio_id = 2;//biopcia
            $modelInforme->estado_actual = $estadoFinal;
            if (!$modelInforme->save()) {
                var_dump(($modelInforme->getErrors()));
                echo "fallo al salvar el model Informe biop";
                return 0;
            }
            $estado = $value["Estado"];

            $modelWorkflow = new Workflow();
            $modelWorkflow->Informe_id = $modelInforme->id;
            $modelWorkflow->Estado_id = $estadoFinal;
            $modelWorkflow->Responsable_id = 5; //christian
            if (!$modelWorkflow->save()) {
                var_dump(($modelWorkflow->getErrors()));
                echo "fallo al salvar el model  Workflow ";
                return 0;
            }
        }
        }
        echo "Finalizo Informe Biopcia\n";
        return 1;
    }



    private function migrarCitologia($conn) {
        $validatorEmail = new EmailValidator();
        $informes = $conn->createCommand("
            SELECT *
            FROM mig_informe_citologia
        ")->queryAll();

        foreach ($informes as $key => $value) {
            $modelProtocolo = Protocolo::find()->where(["id_old" => $value["Protocolo"]])->one();
        if(!empty($modelProtocolo)) {
            if (empty($modelProtocolo)) {
                throw new \yii\base\Exception("Error, al obtener el model protocolo");
            }
            var_dump($value["Protocolo"]);

            $estado = $value["Estado"];
            $estadoFinal = 0;
            switch ($estado) {
                case 0:
                    $estadoFinal = 1;
                    break;
                case 1:
                    $estadoFinal = 3;
                    break;
                case 2:
                    $estadoFinal = 4;
                    break;
                case 4:
                    $estadoFinal = 5;
                    break;
                case 5:
                    $estadoFinal = 5;
                    break;
                case 6:
                    $estadoFinal = 6;
                    break;
            }


            $modelInforme = new Informe();
            $modelInforme->Protocolo_id = $modelProtocolo->id;
            $modelInforme->observaciones = utf8_encode($value["Comentario"]);
            $modelInforme->material = utf8_encode($value["Material"]);
            $modelInforme->tecnica = utf8_encode($value["Tecnica"]);
            $modelInforme->microscopia =utf8_encode($value["Micro"]);
            $modelInforme->macroscopia = utf8_encode($value["Macro"]);
            $modelInforme->diagnostico = utf8_encode($value["Diagnostico"]);
            $modelInforme->Estudio_id = 4;//citologia
            $modelInforme->estado_actual = $estadoFinal;
            if (!$modelInforme->save()) {
                var_dump(($modelInforme->getErrors()));
                echo "fallo al salvar el model informe Citologia";
                return 0;
            }

            $modelWorkflow = new Workflow();
            $modelWorkflow->Informe_id = $modelInforme->id;
            $modelWorkflow->Estado_id = $estadoFinal;
            $modelWorkflow->Responsable_id = 5; //christian
            if (!$modelWorkflow->save()) {
                var_dump(($modelWorkflow->getErrors()));
                echo "fallo al salvar el model  Workflow ";
                return 0;
            }
        }
        }
        echo "Finalizo Informe Citologia\n";
        return 1;
    }



    private function migrarHinmunoHistoQuimico($conn) {
        echo "comienza HinmunoHistoQuimico";
        $validatorEmail = new EmailValidator();
        $informes = $conn->createCommand("
            SELECT *
            FROM mig_informe_ihq
        ")->queryAll();

        foreach ($informes as $key => $value) {
            $modelProtocolo = Protocolo::find()->where(["id_old" => $value["Protocolo"]])->one();
            if(!empty($modelProtocolo)) {
                if (empty($modelProtocolo)) {
                    throw new \yii\base\Exception("Error, al obtener el model protocolo");
                }
                var_dump($value["Protocolo"]);

                $estado = $value["Estado"];
                $estadoFinal = 0;
                switch ($estado) {
                    case 0:
                        $estadoFinal = 1;
                        break;
                    case 1:
                        $estadoFinal = 3;
                        break;
                    case 2:
                        $estadoFinal = 4;
                        break;
                    case 4:
                        $estadoFinal = 5;
                        break;
                    case 5:
                        $estadoFinal = 5;
                        break;
                    case 6:
                        $estadoFinal = 6;
                        break;
                }

                $modelInforme = new Informe();
                $modelInforme->Protocolo_id = $modelProtocolo->id;
                $modelInforme->observaciones = utf8_encode($value["Comentario"]);
                $modelInforme->material = utf8_encode($value["Material"]);
                $modelInforme->tecnica = utf8_encode($value["Tecnica"]);
                $modelInforme->descripcion = utf8_encode($value["Micro"]);
                $modelInforme->tipo = utf8_encode($value["Macro"]);
                $modelInforme->diagnostico = utf8_encode($value["Diagnostico"]);
                $modelInforme->Estudio_id = 5;//inmuno
                $modelInforme->estado_actual = $estadoFinal;
                if (!$modelInforme->save()) {
                    var_dump(($modelInforme->getErrors()));
                    echo "fallo al salvar el model informe HinmunoHistoQuimico";
                    return 0;
                }

                $modelWorkflow = new Workflow();
                $modelWorkflow->Informe_id = $modelInforme->id;
                $modelWorkflow->Estado_id = $estadoFinal;
                $modelWorkflow->Responsable_id = 5; //christian
                if (!$modelWorkflow->save()) {
                    var_dump(($modelWorkflow->getErrors()));
                    echo "fallo al salvar el model  Workflow ";
                    return 0;
                }
            }
        }
        echo "Finalizo Informe HinmunoHistoQuimico\n";
        return 1;
    }


    private function migrarMolecular($conn) {
        $validatorEmail = new EmailValidator();
        $informes = $conn->createCommand("
            SELECT *
            FROM mig_informe_molecular
        ")->queryAll();

        foreach ($informes as $key => $value) {
            $modelProtocolo = Protocolo::find()->where(["id_old" => $value["Protocolo"]])->one();
            if(!empty($modelProtocolo)) {
                if (empty($modelProtocolo)) {
                    throw new \yii\base\Exception("Error, al obtener el model protocolo");
                }
                var_dump($value["Protocolo"]);

                $estado = $value["Estado"];
                $estadoFinal = 0;
                switch ($estado) {
                    case 0:
                        $estadoFinal = 1;
                        break;
                    case 1:
                        $estadoFinal = 3;
                        break;
                    case 2:
                        $estadoFinal = 4;
                        break;
                    case 4:
                        $estadoFinal = 5;
                        break;
                    case 5:
                        $estadoFinal = 5;
                        break;
                    case 6:
                        $estadoFinal = 6;
                        break;
                }

                $modelInforme = new Informe();
                $modelInforme->Protocolo_id = $modelProtocolo->id;
                $modelInforme->observaciones = $value["Comentario"];
                $modelInforme->material = $value["Material"];
                $modelInforme->tecnica = $value["Tecnica"];
                $modelInforme->microscopia = $value["Micro"];
                $modelInforme->macroscopia = $value["Macro"];
                $modelInforme->diagnostico = $value["Diagnostico"];
                $modelInforme->Estudio_id = 3;//mole
                $modelInforme->estado_actual = $estadoFinal;
                if (!$modelInforme->save()) {
                    var_dump(($modelInforme->getErrors()));
                    echo "fallo al salvar el model informe Molecular";
                    return 0;
                }

                $modelWorkflow = new Workflow();
                $modelWorkflow->Informe_id = $modelInforme->id;
                $modelWorkflow->Estado_id = $estadoFinal;
                $modelWorkflow->Responsable_id = 5; //christian
                if (!$modelWorkflow->save()) {
                    var_dump(($modelWorkflow->getErrors()));
                    echo "fallo al salvar el model  Workflow ";
                    return 0;
                }
            }
        }
        echo "Finalizo Informe Molecular\n";
        return 1;
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
        $modelMedico->id_old      = $value["Codigo"];
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
        $prestadoras = $conn->createCommand("SELECT Codigo,Nombre,eMail,Domicilio,Telefonos FROM Cobertura ")->queryAll();
        foreach ($prestadoras as $key => $value) {
            $modelPrestadora= new Prestadoras();
            $modelPrestadora->descripcion           = utf8_encode($value["Nombre"]);
            $modelPrestadora->domicilio             = utf8_encode($value["Domicilio"]);
            $modelPrestadora->telefono              = $value["Telefonos"];
            $modelPrestadora->email                 = $validatorEmail->validate( $value["eMail"],$error) ? utf8_encode($value["eMail"]): "";
            $modelPrestadora->cobertura             = 1;//por defecto son coberturas
            $modelPrestadora->id_old                = $value["Codigo"];
            $modelPrestadora->facturable            ="N";
            //atributos que van por default
            $modelPrestadora->Localidad_id=$modelLocalidad->id;
            $modelPrestadora->Tipo_prestadora_id    =  $modelTipoPrestadora->id;
            if(!$modelPrestadora->save()){
                var_dump(($modelPrestadora->getErrors()));
                echo "fallo al salvar el model Prestadora\n";
                return 0;
            }
        }
        echo "finalizo Prestadora\n";
        return 1;
    }


// en el squema nuevo prestadora hace referencia a coberturas
// prestadoras facturables
    private function migrarCoberturaFacturable($conn) {
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

        $prestadoras = $conn->createCommand("SELECT * from mig_procedencia ")->queryAll();//en el sistema viejo hacen referencia a facturar_a con la tabla procedencia. asi que se crearan entidades facturables a partir de la tabla procedencia
        foreach ($prestadoras as $key => $value) {
            $modelPrestadora= new Prestadoras();
            $modelPrestadora->descripcion           = utf8_encode($value["Nombre"]);
            $modelPrestadora->domicilio             = utf8_encode($value["Domicilio"]);
            $modelPrestadora->telefono              = $value["telefono"];
            $modelPrestadora->email                 = $validatorEmail->validate( $value["eMail"],$error) ? utf8_encode($value["eMail"]): "";
            $modelPrestadora->cobertura             = 0;//por defecto son coberturas
            $modelPrestadora->id_old                = $value["Codigo"];
            $modelPrestadora->facturable            ="S";
            //atributos que van por default
            $modelPrestadora->Localidad_id=$modelLocalidad->id;
            if(!$modelPrestadora->save()){
                var_dump(($modelPrestadora->getErrors()));
                echo "fallo al salvar el model Prestadora Facturable\n";
                return 0;
            }
        }
        echo "finalizo Prestadora Facturable\n";
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
            AlTER TABLE Procedencia   add id_old INT(11);        
            AlTER TABLE Prestadoras   add id_old INT(11);
            AlTER TABLE Paciente      add id_old INT(11);
            AlTER TABLE Protocolo     add id_old INT(11);
            AlTER TABLE Medico        add id_old INT(11);
            
        ")->execute();
        echo "Se agregaron las columnas id_old a las entidades\n";
    }

    private function removeColumsOldId($conecctionNewEsquema)
    {
        $conecctionNewEsquema->createCommand("       
            AlTER TABLE Procedencia   drop id_old;        
            AlTER TABLE Prestadoras   drop id_old;
            AlTER TABLE Paciente      drop id_old;
            AlTER TABLE Protocolo     drop id_old;
            AlTER TABLE Medico        drop id_old;
        ")->execute();;
        echo "Se han eliminado las columnas id_old de las entidades\n";
    }

    private function  clearAllDatabase()
    {
        Workflow::deleteAll();
        Informe::deleteAll();
        Protocolo::deleteAll();
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
        //$this->addColumsOldId($conecctionNewEsquema);
        $this->clearAllDatabase();

        //comienza a migrar los datos de las entidades

        $this->migrarNomenclador($connection);
        $this->migrarEspecialidad($connection);
        $this->migrarMedico($connection);
        $this->migrarCobertura($connection);
        $this->migrarCoberturaFacturable($connection);
        $this->migrarPaciente($connection);
        $this->migrarProcedencia($connection);
        $this->migrarTarifa($connection);

        $this->migrarProtocolo($connection);

        $this->migrarMolecular($connection);
        $this->migrarHinmunoHistoQuimico($connection);
        $this->migrarCitologia($connection);
        $this->migrarBiopcia($connection);
        $this->migrarPap($connection);

        //elimina de las entidades las fk id_old
       // $this->removeColumsOldId($conecctionNewEsquema);
        //$verificar=Informe::find()->all();
        //var_dump($verificar);

    }
    

    public function actionCantidad() {
        $connection = \Yii::$app->dbSqlServerEmpresa;
        // $conecctionNewEsquema = \Yii::$app->dbMysqlServerDedicado;
        $conecctionNewEsquema = \Yii::$app->db;

        $validatorEmail = new EmailValidator();
        $protocolo = $connection->createCommand("
            SELECT count(*)
            FROM mig_protocolo
            where Letra='F' or Letra='L'
        ")->queryAll();

        var_dump($protocolo);
    }



}
