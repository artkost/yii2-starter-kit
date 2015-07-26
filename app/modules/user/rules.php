<?php

return [
    'permissions' => [
        'userView' => 'View User',
        'userCreate' => 'Create User',
        'userUpdate' => 'Update User',
        'userDelete' => 'Delete User',

        'userProfileOwnUpdate' => 'Update Own Profile'
    ],
    'roles' => [
        'user' => 'User',
        'userReader' => 'User Reader',
        'userManager' => 'User Manager',
    ],
    'assignments' => [
        'user' => ['userReader', 'guest'],
        'userReader' => ['userView'],
        'userManager' => [
            'userReader',
            'userCreate',
            'userUpdate',
            'userDelete',
        ],
    ]
];