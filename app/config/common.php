<?php

$params = require(__DIR__ . '/params.php');
$aliases = require(__DIR__ . '/aliases.php');

$config = [
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
    'params' => $params,
];

if (file_exists(__DIR__ . '/db.php')) {
    $config['components']['db'] = require(__DIR__ . '/db.php');
}

return $config;