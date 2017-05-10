<?php

$aliases = require(__DIR__ . '/../../../app/config/aliases.php');

return [
    'id' => 'install',
    'name' => 'install',
    'aliases' => $aliases,
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'install.cookies',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'moduleManager' => [
            'class' => '\app\base\ModuleManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => !YII_ENV_DEV,
            'showScriptName' => YII_ENV_DEV,
            'rules' => [
                '' => 'site/index'
            ],
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
    ],
];
