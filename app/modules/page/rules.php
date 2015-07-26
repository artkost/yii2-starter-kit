<?php

return [
    'permissions' => [
        'pageView' => 'Page View',
        'pageCreate' => 'Page Create',
        'pageUpdate' => 'Page Update',
        'pageDelete' => 'Page Delete',
        'pageModelView' => 'Page View',
        'pageModelCreate' => 'Page Create',
        'pageModelUpdate' => 'Page Update',
        'pageModelDelete' => 'Page Delete',
    ],
    'roles' => [
        'pageReader' => 'Page Reader',
        'pageManager' => 'Page Manager',
    ],
    'assignments' => [
        'pageReader' => ['pageView'],
        'pageManager' => ['userReader', 'createUser', 'updateUser', 'deleteUser'],
    ]
];