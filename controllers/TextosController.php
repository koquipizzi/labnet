<?php

namespace app\controllers;

use Yii;
use app\models\Textos;
use app\models\TextosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * TextosController implements the CRUD actions for Textos model.
 */
class TextosController extends Controller
{
 //   public $layout = 'lay-admin-footer-fixed';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'customtext' => ['POST'],
                ],
            ], 
        ];
    }

    /**
     * Lists all Textos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TextosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Textos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function duplicateModel($id)
    {
        $model = $this->findModel($id);
        // clean up data for new entry
        $model->id = null;   // clear the primary key value
      //  $model->filename = null;  // list what should be cleared here
        $model->isNewRecord = true;    // it's a new record
        return $model;
    }


    public function actionCustomtext(){
        $model = new Textos();
        $request = Yii::$app->request;

        if ($request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if (Textos::find()->where( [ 'codigo' => $model->codigo ] )->exists()){
                    
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'rdo' => 'ko',
                    // 'data' => $data,
                    ];
                }
                else {
                    $model->save();
                   
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'rdo' => 'ok',
                     // 'data' => $data,
                    ];
                    return;
                }
            }    
        } // es ajax
        return;
    }
    /**
     * Creates a new Textos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=null)
    {
        $model = null;

        if (Yii::$app->request->isAjax) {
            $model = new Textos();

            if (isset($_POST['Informe'])){
                
                if (isset($_POST['Informe']['material']))
                    $model->material = $_POST['Informe']['material'];
                /*if (isset($_POST['Informe']['tipo']))
                    $model->macro = $_POST['Informe']['tipo'];*/
                if (isset($_POST['Informe']['tecnica']))    
                    $model->tecnica = $_POST['Informe']['tecnica'];
                if (isset($_POST['Informe']['descripcion']))
                    $model->micro = $_POST['Informe']['descripcion'];
                if (isset($_POST['Informe']['microscopia']))
                    $model->micro = $_POST['Informe']['microscopia'];
                if (isset($_POST['Informe']['macroscopia']))
                    $model->macro = $_POST['Informe']['macroscopia'];
                if (isset($_POST['Informe']['diagnostico']))
                    $model->diagnos = $_POST['Informe']['diagnostico'];
                if (isset($_POST['Informe']['observaciones']))
                    $model->observ = $_POST['Informe']['observaciones'];
                if (isset($_POST['Informe']['Estudio_id']))
                    $model->estudio_id = $_POST['Informe']['Estudio_id'];
                if (isset($_POST['codigo']))
                    $model->codigo = $_POST['codigo'];
                if (isset($_POST['Informe']['citologia']))
                    $model->macro = $_POST['Informe']['citologia'];                    
            }
            if (isset($_POST['Textos'])){
                if (isset($_POST['Textos']['material']))
                    $model->material = $_POST['Textos']['material'];
                if (isset($_POST['Textos']['tipo']))
                    $model->tipo = $_POST['Textos']['tipo'];
                if (isset($_POST['Textos']['tecnica']))
                    $model->tecnica = $_POST['Textos']['tecnica'];
                if (isset($_POST['Textos']['micro']))
                    $model->micro = $_POST['Textos']['micro'];
                if (isset($_POST['Textos']['macro']))
                    $model->macro = $_POST['Textos']['macro'];
                if (isset($_POST['Textos']['diagnos']))
                    $model->diagnos = $_POST['Textos']['diagnos'];
                if (isset($_POST['Textos']['observ']))
                    $model->observ = $_POST['Textos']['observ'];
                if (isset($_POST['Textos']['estudio_id']))
                    $model->estudio_id = $_POST['Textos']['estudio_id'];
                if (isset($_POST['Textos']['estudio_id']))
                    $model->codigo = $_POST['Textos']['codigo'];
            }

            if ($model->estudio_id == '4'){//cito
            
                $data = $this->renderAjax('_form_pop_cito', ['model' => $model]);
            }
            else if ($model->estudio_id == 1){ //pap
                $data = $this->renderAjax('_form_pop', ['model' => $model]);
            }
            else if ($model->estudio_id == 3){ //mole
                $data = $this->renderAjax('_form_pop_mole', ['model' => $model]);
            }else{
              
                 $data = $this->renderAjax('_form_pop', [
                'model' => $model]);
             } 
         //   }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'rdo' => 'ok',
                'data' => $data,
            ];
            return;
        }
        if ($id === null || isset($_POST['Textos']))
            $model = new Textos();
        else
            $model = $this->duplicateModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionCopy($id=null)
    {
        
        if ($id === null || isset($_POST['Textos']))
            $model = new Textos();
        else
            $model = $this->duplicateModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('copy',[
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Textos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Textos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       if ($this->findModel($id)->delete()){
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'ok', 'message'=>''];die();
        }
        else {
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                     return ['rta'=>'error', 'message'=>''];die();
        }
    }

    /**
     * Finds the Textos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Textos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Textos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTree($estudio){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Textos();
        $estudio = 'B';
        $query = "SELECT * FROM Textos where `codigo` LIKE '".$estudio."%' ";
        $result = \app\models\Textos::findBySql($query)->all();
        //var_dump($result); die();
        $tree = new \app\controllers\AutoTextTreeController();
        foreach ($result as $row){
            $url = Url::to(['',  'id' => '1', 'idtexto'=> $row['id']]);
            $tree->merge($row['codigo'], $url);
        }
        return $this->render('create', [
                'model' => $model,'item'=> date('H:i:s')
            ]);

        die();

    }
}
