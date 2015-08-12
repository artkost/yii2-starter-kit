<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');


return [
    'id' => 'console',
    'controllerNamespace' => 'app\commands',


    'controllerMap' => [
        'migrate' => [
            'class' => 'dmstr\console\controllers\MigrateController'
        ],
    ],

    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ]
];
