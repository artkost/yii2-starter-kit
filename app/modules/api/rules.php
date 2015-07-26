<?php

return [
    'permissions' => [
        'apiView' => 'View Api',
        'apiCreate' => 'Create Api',
        'apiUpdate' => 'Update Api',
        'apiDelete' => 'Delete Api',
    ],
    'roles' => [
        'api' => 'Api',
        'apiReader' => 'Api Reader',
        'apiManager' => 'Api Manager',
    ],
    'assignments' => [
        'api' => ['apiReader'],
        'apiReader' => ['apiView'],
        'apiManager' => [
            'apiReader',
            'apiCreate',
            'apiUpdate',
            'apiDelete',
        ],
    ]
];
