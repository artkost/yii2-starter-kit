<?php

return [
    'id' => 'console',
    'controllerNamespace' => 'app\commands',

    'controllerMap' => [
        'migrate' => 'bariew\moduleMigration\ModuleMigrateController'
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
