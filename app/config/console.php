<?php
require_once(__DIR__ . '/../base/ModuleManager.php');
use app\base\ModuleManager;

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$aliases = require(__DIR__ . '/aliases.php');
$db = require(__DIR__ . '/db.php');
$routes = require(__DIR__ . '/routes.php');
$rbac = require(__DIR__ . '/rbac.php');

$modules = ModuleManager::getConfig('console');

$bootstrap = ModuleManager::getBootstrap();
$bootstrap[] = 'log';

return [
    'id' => 'anidesu',
    'basePath' => dirname(__DIR__),
    'bootstrap' => $bootstrap,
    'aliases' => $aliases,
    'controllerNamespace' => 'app\commands',

    'modules' => $modules,

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
