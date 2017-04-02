<?php

namespace app\controllers;
use app\models\InformeTemp;
use app\models\InformeTempSearch;
use app\models\Nomenclador;
use app\models\InformeNomencladorTemporal;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\web\NotFoundHttpException;


class InformetempController extends \yii\web\Controller
{
    public function actionIndex()
    { 
        $model= new InformeTemp();  
        return $this->renderAjax('i_form',[
                              'informe'=>$model,
                                ]);
    }
   public function actionCreate()
    {
//       die
 //       var_dump( $_POST); die();
        $nomencladores=array();
        $model= new InformeTemp();  
        $model->session_id=Yii::$app->session->getId(); 
        //var_dump($_POST['InformeTemp']['tanda']);   die();
        //
        if ($_POST['InformeTemp']['tanda'] !== '0')
            $tanda = $_POST['InformeTemp']['tanda'];
        else $tanda =  time();
            $model->tanda = $tanda;
        //    var_dump($model); die();
        try {

            if ($model->load(Yii::$app->request->post()) && $model->save())
                {
                    $searchModel = new InformeTempSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$tanda);
                    $query = InformeTemp::find()->where(['tanda' => $tanda]);

                    $dataProvider = new ActiveDataProvider(['query' => $query,]);
                    $nomencladores= $_POST['Nomenclador']['servicio'];
                    if(!empty($nomencladores))
                    {
                        try {
                            $connection = \Yii::$app->db;
                            $transaction = $connection->beginTransaction();

                            foreach ($nomencladores as $n=>$descripcion )
                                {
                                    $informeNomencladorTemp = new InformeNomencladorTemporal();
                                    $informeNomencladorTemp->id_nomenclador=$descripcion;
                                    $informeNomencladorTemp->id_informeTemp= $model->id;
                                    $informeNomencladorTemp->save();
                                }
                            $transaction->commit();
                        } catch (\Exception $e)
                                {
                                    $transaction->rollBack();
                                    throw $e;
                        }
                    }

                //    var_dump( $_POST); die();
                    $done =  $this->renderAjax('//protocolo/_grid',[
                                        'dataProvider'=>$dataProvider,
                                        'tanda'=>$tanda,
                                        'informe'=>$model
                                    ]);;

                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return array(
                        "data" => $done,
                        "tanda" => $tanda
                    );
            }
        }
        catch (ErrorException $e) {  
            Yii::$app->response->format = Response::FORMAT_JSON;
                    return array(
                   //     "data" => $done,
                        "mensaje" => $e
                    );  
               //     return 'error'.$e;
        }
    }
 
    
    public function actionGetAll()
    {
         
        //
    }

    
     /**
     * Deletes an existing PacientePrestadora model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return;// $this->redirect(['index']);
    }

  
    
   protected function findModel($id)
    {
        if (($model = Informetemp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}

        
 