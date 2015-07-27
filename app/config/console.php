<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$aliases = require(__DIR__ . '/aliases.php');
$db = require(__DIR__ . '/db.php');
$routes = require(__DIR__ . '/routes.php');
$rbac = require(__DIR__ . '/rbac.php');

return [
    'id' => 'anidesu',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        '\app\base\ModuleManager',
    ],
    'aliases' => $aliases,
    'controllerNamespace' => 'app\commands',

    'modules' => [],

    'controllerMap' => [
        'migrate' => [
            'class' => 'dmstr\console\controllers\MigrateController'
        ],
    ],

    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'attachmentManager' => [
            'class' => 'artkost\attachment\Manager',
            'storageUrl' => '@web/storage',
            'storagePath' => '@webroot/storage',
            'attachmentFileTable' => '{{%attachment_file}}'
        ],
        'authManager' => $rbac,
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
