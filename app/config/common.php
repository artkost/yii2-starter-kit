<?php

$params = require(__DIR__ . '/params.php');
$aliases = require(__DIR__ . '/aliases.php');
$db = require(__DIR__ . '/db.php');
$redis = require(__DIR__ . '/redis.php');

return [
    'aliases' => $aliases,
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        '\app\base\ModuleManager',
    ],
    'modules' => [],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'moduleManager' => [
            'class' => '\app\base\ModuleManager',
        ],
        'attachmentManager' => [
            'class' => 'artkost\attachment\Manager',
            'storageUrl' => '@web/storage',
            'storagePath' => '@webroot/storage',
            'attachmentFileTable' => '{{%attachment_file}}'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_item}}',
            'itemChildTable' => '{{%rbac_item_child}}',
            'assignmentTable' => '{{%rbac_assignment}}',
            'ruleTable' => '{{%rbac_rule}}',
            'defaultRoles' => ['guest'],
            'cache' => 'cache'
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
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
        'redis' => $redis,
    ],
    'params' => $params,

];
