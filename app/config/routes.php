<?php

return [
    '' => 'site/index',

    'news' => 'news/default/index',
    'news/tag/<name>' => 'news/default/tag',
    'news/<url>' => 'news/default/view',

    'films' => 'film/default/index',
    'film/<url>' => 'film/default/view',

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
