<?php

use yii\helpers\ArrayHelper;

$web = require(__DIR__ . '/web.php');

$admin = [
    'id' => 'admin',
    'defaultRoute' => 'admin',
    'components' => [
        'view' => [
            'theme' => '\app\themes\admin\Theme'
        ],
        'errorHandler' => [
            'errorAction' => '/admin/default/error'
        ],
        'urlManager' => [
            'showScriptName' => true
        ]
    ]
];

$merged = ArrayHelper::merge($web, $admin);
$merged['components']['urlManager']['rules'] = [];

$merged['bootstrap'] = [
    ['class' => '\app\themes\admin\Theme']
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $merged['bootstrap'][] = 'debug';
    $merged['modules']['debug'] = 'yii\debug\Module';
}

return $merged;
