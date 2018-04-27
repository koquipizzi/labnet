<?php
use kartik\datecontrol\Module; //se usa más abajo
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],//, 'audit'
    'language'=>'es', // spanish
    'params' => $params,
    'modules' => [
        'simplechat' => [
            'class' => 'bubasuma\simplechat\Module',
        ],
       //  'audit' => [
       //      'class' => 'bedezign\yii2\audit\Audit',
 		//	'panelsMerge' => [
 		//		'app/views' => [
 		//			'class' => '@app\views\panels\ViewsPanel',
 		//		],
 		//	],
		//],

         'comment' => [
            'class' => 'yii2mod\comments\Module',
            // when admin can edit comments on frontend
            'enableInlineEdit' => true,
            'controllerMap' => [
            //    'comments' => 'yii2mod\comments\controllers\ManageController',
                // Also you can override some controller properties in following way:
                'comments' => [
                    'class' => 'yii2mod\comments\controllers\ManageController',
                    'searchClass' => [
                        'class' => 'yii2mod\comments\models\search\CommentSearch',
                        'pageSize' => 25
                    ],
                    'indexView' => '@vendor/yii2mod/yii2-comments/views/manage/index',
                    'updateView' => '@vendor/yii2mod/yii2-comments/views/manage/update',
                ],
            ]  
        ],
        'admin' => [
           'class' => 'mdm\admin\Module',
           'layout' => 'left-menu', // defaults to null, using the application's layout without the menu
        ],
         'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd/MM/yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd/MM/yyyy hh:mm:ss a',
            ],

            //format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d',
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            // set your display timezone
            'displayTimezone' => 'America/Argentina/Buenos_Aires',

            // set your timezone for date saved to db
            'saveTimezone' => 'America/Argentina/Buenos_Aires',

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

            // use ajax conversion for processing dates from display format to save format.
            'ajaxConversion' => true,
        ]
    ],
    'components' => [
         /*   'assetManager' => [
                'bundles' => [
                    'mimicreative\react\ReactAsset' => [
                    'js' => [
                        'react.js',
                        'react-dom.js'
                    ]
                    ],
                    'mimicreative\react\ReactWithAddonsAsset' => [
                    'js' => [
                        'react-with-addons.js',
                        'react-dom.js'
                    ]
                    ]
                ]
            ],*/
            /*'view' => [
                'theme' => [
                    'pathMap' => [
                        '@vendor/dektrium/rbac/views' => '@vendor/cinghie/yii2-user-extended/views',
                        '@vendor/dektrium/user/views' => '@vendor/cinghie/yii2-user-extended/views',
                    ],
                ],
            ],*/
            'qr' => [
                'class' => '\Da\QrCode\Component\QrCodeComponent',
                // ... you can configure more properties of the component here
            ],
     //       'kint' => [
       //         'class' => '@vendor/kint-php/kint/src',
                // ... you can configure more properties of the component here
         //   ],
            'i18n' => [
                'translations' => [
                    'app*' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'basePath' => '@app/common/messages',
                        'sourceLanguage' => 'es-ES',
                        'fileMap' => [
                            'app' => 'app.php',
                            'app/error' => 'error.php',
                        ],
                    ],
                    'yii2mod.comments' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                      //  'basePath' => '@yii2mod/comments/messages',
                        'sourceLanguage' => 'es-ES',
                        'basePath' => '@app/common/messages',
                    ],
                    'yii' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'sourceLanguage' => 'es-ES',
                        'basePath' => '@app/common/messages',
                        'sourceLanguage' => 'es-ES',
                        'fileMap' => [
                            'yii' => 'yii.php',
                            //'app/error' => 'error.php',
                        ],
                    ],
                ],
            ],
   /*     'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
        */
        'authManager' => [
             'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xJUEoJ6HdS8pQxuW4N-FaeVTqWWTjNEL',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
         //   'useFileTransport' => true,
          //  'viewPath' => '@app/mail',
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.qwavee.com',
                'username' => 'hola@qwavee.com',
                'password' => 'Hola!321',
                'port' => '26',
                'encryption' => 'tls',
                 'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            //'enablePrettyUrl' => true,
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'rules' => [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'post',
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
		'allowActions' => [
			'admin/*', // add or remove allowed actions to this list
            'comment/*',
         //   'audit/*',
            'debug/*'
		]
    ],
    'params' => $params,
    'aliases'=>[
        //'@asset'=> dirname(dirname(dirname(dirname(rtrim(dirname($_SERVER['PHP_SELF']), '\\/'))))).'/assets/'
        '@asset'=> rtrim(dirname($_SERVER['PHP_SELF']), '\\/').'/assets/',
   //     '@mdm/admin' => rtrim(dirname($_SERVER['PHP_SELF']), '\\/').'/vendor/mdmsoft/yii2-admin/',
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
