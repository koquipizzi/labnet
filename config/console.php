<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'dbSqlServer' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'dblib:host=192.168.3.109;port=1433;dbname=hellmund',
            'username' => 'sa',
            'password' => 'hellmund',
            'charset' => 'utf-8',
        ],
        'dbSqlServerEmpresa' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'dblib:host=10.0.0.201;port=1433;dbname=hellmund',
            'username' => 'sa',
            'password' => 'hellmund',
            'charset' => 'utf-8',
        ],
        'dbMysqlServerDedicado' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'mysql:host=192.168.3.109;port=3307;dbname=test_labnet',
            'username' => 'root',
            'password' => 'mysqlp4ss',
        ],
            
       /*  'authManager' => [
             'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],*/
    ],
    'params' => $params,
   
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
