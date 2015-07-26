<?php

require_once(__DIR__ . '/../base/ModuleManager.php');

use app\base\ModuleManager;

$params = require(__DIR__ . '/params.php');
$aliases = require(__DIR__ . '/aliases.php');
$db = require(__DIR__ . '/db.php');
$routes = require(__DIR__ . '/routes.php');
$rbac = require(__DIR__ . '/rbac.php');

$modules = ModuleManager::getConfig();
$bootstrap = ModuleManager::getBootstrap();

$bootstrap[] = [
    'class' => $params['theme']
];
$bootstrap[] = 'log';

$config = [
    'id' => 'basic',
    'name' => $params['title'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => $bootstrap,
    'aliases' => $aliases,
    'modules' => $modules,
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $params['cookieKey'],
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $routes,
        ],
        'attachmentManager' => [
            'class' => 'artkost\attachment\Manager',
            'storageUrl' => '@web/storage',
            'storagePath' => '@webroot/storage',
            'attachmentFileTable' => '{{%attachment_file}}'
        ],
        'authManager' => $rbac,
        'view' => [
            'theme' => [
                'class' => $params['theme']
            ]
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/default/error',
        ],
        'mail' => [
            'class' => 'app\base\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace'],
                ],
            ],
        ],
        'db' => $db,
        'redis' => require(__DIR__ . '/redis.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
