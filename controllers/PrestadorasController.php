<?php

namespace app\controllers;

use Yii;
use app\models\Prestadoras;
use app\models\Localidad;
use app\models\PrestadorasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;

use yii\helpers\ArrayHelper;
//use yii\filters\VerbFilter;

/**
 * PrestadorasController implements the CRUD actions for Prestadoras model.
 */
class PrestadorasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                     'delete' => ['POST'],
//                ],
//            ],
        ];
    }
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all Prestadoras models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Prestadoras();
        $searchModel = new PrestadorasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionIndexfacturable()
    {
        $model = new Prestadoras();
        $searchModel = new PrestadorasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, "F");

        return $this->render('indexfacturable', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Prestadoras model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
     $model =  $this->findModel($id);
    if (!$model) {
        // Handle the case when model with given id does not exist
    }
    return $this->render('view', ['id' => $model->id,  'model' => $this->findModel($id)]);
    die();
    }

    /**
     * Displays a single Entidad facturable .
     * @param integer $id
     * @return mixed
     */
    public function actionViewfacturable($id)
    {
        $model =  $this->findModel($id);
        if (!$model) {
            // Handle the case when model with given id does not exist
        }
        return $this->render('viewfacturable', ['id' => $model->id,  'model' => $this->findModel($id)]);
     //   die();
    }
    /**
     * Creates a new Prestadoras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreateprepaga()
    {        
        $model = new Prestadoras();

        if ($model->load(Yii::$app->request->post())){
            $model->cobertura=1;
                if($model->facturable==="1"){
                    $model->facturable='S';
                 }else{
                      $model->facturable='N';
                 }
            $model->save();   
            $this->redirect(['view', 'id' => $model->id]);
        }
        else {
                 return $this->render('_form', ['model' => $model]);
             }

    }
    public function actionCreatefacturable()
    {
        $model = new Prestadoras();

        if ($model->load(Yii::$app->request->post())) {
            $model->cobertura=0;
            $model->facturable='S';
            $model->save();
             $this->redirect(['viewfacturable', 'id' => $model->id]);
        }
        else{
                return $this->render('_formfacturable', ['model' => $model ]);
             }

    }


    public function actionCreate_pop()
    {  
        $model = new Prestadoras();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                     $dataProvider = new ActiveDataProvider([
                        'query' => Prestadoras::find()
                    ]);
                    $searchModel = new PrestadorasSearch();
                    return $this->render('index', [
                       'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel
                    ]);
          //  return $this->renderAjax(['index', 'id' => $model->id]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate_modal()
    {  
        $model = new Prestadoras();

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
                     $dataProvider = new ActiveDataProvider([
                        'query' => Prestadoras::find()
                    ]);
                    $searchModel = new PrestadorasSearch();
                    return $this->render('index', [
                       'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel
                    ]);
          //  return $this->renderAjax(['index', 'id' => $model->id]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
        */
       
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save()) {
             header('Content-type: application/json');
            $response = ["result" => "ok", "mensaje" => "Se guardó la prestadora"];
            echo \yii\helpers\Json::encode($response);
            exit();

            }
            if (!$model->save())
            {
                $mensaje = [];
                 foreach ($model->getErrors () as $attribute => $error)
                {
                        foreach ($error as $message) {
                            $mensaje[] = $message;
                        }
                }
                header('Content-type: application/json');
                $response = ["result" => "error", "mensaje" => $mensaje];
                echo \yii\helpers\Json::encode($response);
                exit();
            }
        }
        else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form_modal', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Prestadoras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['view', 'id' => $model->id]);
        } else { 
            return $this->render('_form', [
                'model' => $model
            ]); die();
        }
    }



    /**
     * Updates an existing Entidad facturable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdatefacturable($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['viewfacturable', 'id' => $model->id]);
        } else {
            return $this->render('_formfacturable', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate_pop($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Prestadoras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {     
        try {
            if($this->findModel($id)->delete()){
                if (Yii::$app->getRequest()->isAjax) {
                    return 'ok';
                }
            }
        } catch (\yii\db\IntegrityException $exc) {
                        //notificar catch
            return 'error';
        }        
    }
    /**
     * Deletes an existing Entidad Facturable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeletefacturable($id)
    {
        try {
            if($this->findModel($id)->delete()){
                if (Yii::$app->getRequest()->isAjax) {
                    return 'ok';
                }
            }
        } catch (\yii\db\IntegrityException $exc) {
            //notificar catch
            return 'error';
        }
    }

    /**
     * Finds the Prestadoras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prestadoras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prestadoras::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCreatepop()
    {
        $model = new Prestadoras();

        if ($model->load(Yii::$app->request->post())){
            $model->cobertura=1;
                if($model->facturable==="1"){
                    $model->facturable='S';
                 }else{
                      $model->facturable='N';
                 }
            $model->save();   
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['rta'=>'ok', 'message'=>'','data_id'=>$model->id, 'data_nombre'=>$model->descripcion];
        }
       else {
            return $this->renderAjax('create_form_pop', [
                        'model' => $model
            ]);
        }
    }

    public function actionList($term = NULL)
    {   header('Content-type: application/json');
        $clean['more'] = false;

        $query = new \yii\db\Query;
        if(!empty($term)) {
            $mainQuery = $query->select('Prestadoras.id
                                        ,descripcion
                                        ')
                                ->from('Prestadoras')
                                ->where(['like','Prestadoras.descripcion',$term])
                                ->limit(15);                       //limito a 15, para mejorar performance
            $command = $mainQuery->createCommand();
            $rows = $command->queryAll();
            $clean['results'] = array_values($rows);
        }
        echo \yii\helpers\Json::encode($clean['results']);
        exit();
    }

    public function actionFacturar($term = NULL)
    {   header('Content-type: application/json');
        $clean['more'] = false;

        $query = new \yii\db\Query;
        if(!empty($term)) {
            $mainQuery = $query->select('Prestadoras.id
                                        ,descripcion
                                        ')
                                ->from('Prestadoras')
                                ->where(['like','Prestadoras.descripcion',$term])
                                ->andWhere(['like','Prestadoras.facturable',"S"])
                                ->limit(15);                       //limito a 15, para mejorar performance
            $command = $mainQuery->createCommand();
            $rows = $command->queryAll();
            $clean['results'] = array_values($rows);
        }
        echo \yii\helpers\Json::encode($clean['results']);
        exit();
    }


  


}
