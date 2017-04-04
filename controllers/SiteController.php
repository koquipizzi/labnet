<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    
    
  //  public $layout = 'lay-admin-footer-fixed';
   // public $layout = 'lay-admin-footer-fixed';
    
/*    
    public $globalStyles = ['/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css'];
    
    public $pageLevelStyles = ['/global/plugins/bower_components/fontawesome/css/font-awesome.min.css',
        '/global/plugins/bower_components/animate.css/animate.min.css'];
    
    public $themeStyles = ['/frontend/css/landing.css'];
    
    
    public $corePlugins = [ '/global/plugins/bower_components/jquery/dist/jquery.min.js',
                            '/global/plugins/bower_components/jquery-cookie/jquery.cookie.js',
                            '/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js',
                            '/global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js',
                            '/global/plugins/bower_components/jpreloader/js/jpreloader.min.js',
                            '/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js',
                            '/global/plugins/bower_components/ionsound/js/ion.sound.min.js'
                        ];
    
    public $pageLevelPlugins = ['/global/plugins/bower_components/jquery-waypoints/waypoints.min.js',
        '/global/plugins/bower_components/jquery-waypoints/shortcuts/sticky-elements/waypoints-sticky.min.js'];
    
    public $pageLevelScripts = ['frontend/landing-page/js/blankon.landing.js'];
*/    
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
        return $this->render('index');
	//$this->redirect(['/admin/dashboard/index']);
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
