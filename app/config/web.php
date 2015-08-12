<?php

$routes = require(__DIR__ . '/routes.php');

$config = [
    'id' => 'site',
    'name' => $params['title'],
    'bootstrap' => [
        $params['theme']
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $params['cookieKey'],
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'class' => 'app\web\User',
            'identityClass' => 'app\models\User',
            'loginUrl' => ['/user/default/login'],
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
        'errorHandler' => [
            'errorAction' => 'site/default/error',
        ],
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
