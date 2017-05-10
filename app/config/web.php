<?php

$routes = require(__DIR__ . '/routes.php');
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'site',
    'name' => $params['title'],
    'bootstrap' => [
        'log',
        '\app\base\ModuleManager',
        $params['theme']
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $params['cookie.key'],
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'assetManager' => [
            'linkAssets' => YII_DEBUG
        ],
        'urlManager' => [
            'enablePrettyUrl' => !YII_ENV_DEV,
            'showScriptName' => YII_ENV_DEV,
            'rules' => $routes,
        ],
        'view' => [
            'theme' => [
                'class' => $params['theme']
            ]
        ],
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
