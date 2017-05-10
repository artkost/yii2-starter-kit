<?php

use yii\helpers\ArrayHelper;

$web = require(__DIR__ . '/web.php');

$admin = [
    'id' => 'admin',
    'defaultRoute' => 'admin',
    'components' => [
        'view' => [
            'theme' => [
                'class' => '\app\themes\admin\Theme'
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        'urlManager' => [
            'showScriptName' => true
        ],
    ]
];

$merged = ArrayHelper::merge($web, $admin);
/**
 * Clear public url rules, we use only defined for admin
 */
$merged['components']['urlManager']['rules'] = [];
$merged['bootstrap'] = ['log'];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $merged['bootstrap'][] = 'debug';
    $merged['modules']['debug'] = 'yii\debug\Module';
}

$merged['bootstrap'][] = '\app\base\ModuleManager';
$merged['bootstrap'][] = '\app\themes\admin\Theme';

return $merged;
