<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Paciente;
use app\models\Informe;
use app\models\Tag;
use app\models\Protocolo;
use app\models\ProtocoloSearch;
use app\models\Laboratorio;
use yii\db\Query;

class SiteController extends Controller
{
      
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
    public function actionIndex()
    {
        $c = Paciente::find()->count();
        $i = Informe::find()->count();
        $p = Informe::find()->where('Estudio_id = 1')->count();
        $m = Informe::find()->where('Estudio_id = 3')->count();
        $b = Informe::find()->where('Estudio_id = 2')->count();
        $ci = Informe::find()->where('Estudio_id = 4')->count();
        $in = Informe::find()->where('Estudio_id = 5')->count();
        $sql = "SELECT * FROM tag order by frequency desc limit 5";
        $connection = \Yii::$app->db;
        $model = $connection->createCommand($sql);
        $tags = $model->queryAll();
    //    var_dump($tags[8]['name']); die();

        $tagsLabels = [];
        $frequencies = [];
        for ($i = 0; $i < 5; $i++)
        {
            $tagsLabels[] = $tags[$i]['name'];
            $frequencies[] = $tags[$i]['frequency'];
        }
   //     $model = Tag::findBySql($sql)->all();
        //$tags = Tag::find()->all();

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
         return $this->render('index', ['c'=> $c, 'i'=> $i,  'p'=> $p,
                            'm'=> $m,'b'=> $b, 'ci'=> $ci, 'in'=> $in,
                            'meses'=> $meses, 'cantidades'=> $cantidades,
                            'propios'=> $propios, 
                            'tags'=> $tagsLabels, 
                            'frequencies'=> $frequencies,
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
}
