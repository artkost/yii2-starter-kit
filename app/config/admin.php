<?php

require_once(__DIR__ . '/../base/ModuleManager.php');

use app\base\ModuleManager;
use yii\helpers\ArrayHelper;

$web = require(__DIR__ . '/web.php');

$admin = [
    'id' => 'adminPanel',
    'defaultRoute' => 'admin',
    'modules' => [],
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

foreach ($web['modules'] as $id => $module) {
    if (is_array($module)) {
        $admin['modules'][$id]['controllerNamespace'] = "app\\modules\\{$id}\\admin\\controllers";
        $admin['modules'][$id]['viewPath'] = "@app/modules/{$id}/admin/views";
    }
}

$merged = ArrayHelper::merge($web, $admin);

$merged['components']['urlManager']['rules'] = [];

$merged['bootstrap'] = ModuleManager::getBootstrap();
$merged['bootstrap'][] = ['class' => '\app\themes\admin\Theme'];
$merged['bootstrap'][] = 'log';

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $merged['bootstrap'][] = 'debug';
    $merged['modules']['debug'] = 'yii\debug\Module';

//    $merged['bootstrap'][] = 'gii';
//    $merged['modules']['gii'] = [
//        'class' => 'yii\gii\Module'
//    ];
}

return $merged;
