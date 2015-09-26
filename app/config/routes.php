<?php

return [
    '' => 'site/index',
    [
        'class' => 'yii\rest\UrlRule',
        'prefix' => 'v1',
        'suffix' => '.json',
        'controller' => [
            'users' => 'api/users',
            'films' => 'api/films',
        ]
    ],
];
