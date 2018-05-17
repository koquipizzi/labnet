<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Paciente;
use app\models\Medico;
use app\models\Informe;
use app\models\Tag;
use app\models\Protocolo;
use app\models\ProtocoloSearch;
use app\models\Laboratorio;
use yii\db\Query;

class SiteController extends Controller
{
    const ID_ENTIDAD_TODAS = 1;
    const ID_ENTIDAD_PACIENTES = 2;
    const ID_ENTIDAD_PROTOCOLOS = 3;
    const ID_ENTIDAD_MEDICOS = 4;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(){
        
        $c = Paciente::find()->count();
        $infc = Informe::find()->count();
        $p = Informe::find()->where('Estudio_id = 1')->count();
        $m = Informe::find()->where('Estudio_id = 3')->count();
        $b = Informe::find()->where('Estudio_id = 2')->count();
        $ci = Informe::find()->where('Estudio_id = 4')->count();
        $in = Informe::find()->where('Estudio_id = 5')->count();
        $sql = "SELECT * FROM Tag order by frequency desc limit 5";
        $connection = \Yii::$app->db;
        $model = $connection->createCommand($sql);
        $tags = $model->queryAll();

        $tagsLabels = [];
        $frequencies = [];
        if(!empty($tags)){
            for ($i = 0; $i < 5; $i++) {
                $tagsLabels[] = $tags[$i]['name'];
                $frequencies[] = $tags[$i]['frequency'];
            }
        }
        
        $searchProtocolos = new ProtocoloSearch();
        $propios = $searchProtocolos->search_asignados_index(2, NULL);

        $meses = [];
        $cantidades = [];
        for ($i = 0; $i <= 12; $i++)
        {
            $mesmenos = "-".$i." month";
            $time = strtotime($mesmenos, time());
            $dateFinal = date("Y-m-d", $time);
            $mes = date("m", strtotime($dateFinal));
            $anio = date("Y", strtotime($dateFinal));
            $sql = Protocolo::find()->where(' Year(fecha_entrada)='.$anio.' and Month(fecha_entrada) ='. $mes)->count();
            $meses[] = $mes."-".$anio;
            $cantidades[] = $sql;
        }
      
        
        return $this->render('index', [
                        'c'=> $c,
                        'i'=> $infc,
                        'p'=> $p,
                        'm'=> $m,
                        'b'=> $b,
                        'ci'=> $ci,
                        'in'=> $in,
                        'meses'=> $meses,
                        'cantidades'=> $cantidades,
                        'propios'=> $propios
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
   //     var_dump(Yii::$app->user); die();
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

  //      $this->layout = 'lay-account';
          $this->layout = 'main-login';
   //    $this->layout = '../site/login';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    private function searchAll($searchFeld){
        $infoPaciente = Paciente::find()->where(['LIKE', 'nombre', $searchFeld])->all();
        $infoMedico = Medico::find()->where(['LIKE', 'nombre', $searchFeld])->all();
        $infoProtocolo = Protocolo::find()->where(['LIKE', 'observaciones', $searchFeld])->all();
        $info = array_merge($infoPaciente,$infoMedico);
        $info = array_merge($info,$infoProtocolo);
        return ['resultados' => $info , 'field' =>$searchFeld ];
    }
    
    public function actionSearch(){
        $searchFeld = Yii::$app->request->post('q');
        $response = $this->searchAll($searchFeld);
        $html = $this->renderAjax('resultadosBusqueda', $response);
        return $this->render('search', ['html' => $html, 'searchFeld' => $searchFeld] );
    }
    
    public function actionFiltrarBusqueda(){
        $textoIngresado = 0;
        $informes = 0;
        $fecha = 0;
        $entidad = 0;
        $tipoDeEstudio = 0;
        $response = [];
    
        try{
            
            if (empty(Yii::$app->request->post())) {
                throw new Exception('No se encontro una solicitud post');
            }
            
            if (!empty(Yii::$app->request->post('palabra'))){
                $textoIngresado =  Yii::$app->request->post('palabra');
            }
            if (!empty(Yii::$app->request->post('entidad'))){
                $entidad = (int) Yii::$app->request->post('entidad');
            }
            if (!empty(Yii::$app->request->post('fecha'))){
                $fecha =  Yii::$app->request->post('fecha');
                if (!empty($fecha)){
                    $fecha = new \DateTime();
                    $fecha->setTimestamp(Yii::$app->request->post('fecha'));
                }
            }
            if (!empty(Yii::$app->request->post('tipoInforme'))){
                $tipoDeEstudio =  Yii::$app->request->post('tipoInforme');
            }
            $query = [];
            if (!empty($entidad)){
                if ($entidad == self::ID_ENTIDAD_TODAS){
                    $info = $this->searchAll($textoIngresado);
                }elseif ($entidad == self::ID_ENTIDAD_PACIENTES){
                    $info['resultados'] = Paciente::find()->where(['LIKE', 'nombre', $textoIngresado])->all();
                    $info['field'] = $textoIngresado;
                }elseif ($entidad == self::ID_ENTIDAD_PROTOCOLOS){
                    $query = Protocolo::find()->where(['LIKE', 'observaciones', $textoIngresado])->all();
                    /*$query = Protocolo::find()->select('id')->where(['LIKE', 'observaciones', $textoIngresado])->all();
                    if (!empty($tipoDeEstudio)){
                        $informes = Informe::find()->where(['in','protocolo_id',$query])->andFilterWhere(['estudio_id' => $tipoDeEstudio])->all();
                    }
                    $info['resultados'] = $informes;*/
                    $info['resultados'] = $query;
                    $info['field'] = $textoIngresado;
                }elseif ($entidad == self::ID_ENTIDAD_MEDICOS){
                    $info['resultados'] = Medico::find()->where(['LIKE', 'nombre', $textoIngresado])->all();
                    $info['field'] = $textoIngresado;
                }
            }
            $html = $this->renderAjax('resultadosBusqueda', $info);
    
            $response = ["result" => "ok", "mensaje" => "La busqueda se realizo correctamente", 'info' => $html ];
            
        }catch (Exception $e){
            $response = ["result" => "error", "mensaje" => "Se encontro un error durante el proceso"];
        }
        \Yii::$app->response->format = 'json';
        return $response;
    }
}
