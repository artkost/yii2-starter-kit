<?php

use app\modules\admin\models\ModuleDefinition;

return [
    'name' => 'User Managment',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'required' => true,

    'menu' => [
        'user.index' => [
            'title' => 'Users',
            'weight' => 7,
            'icon' => 'fa-user'
        ],
        'user.create' => [
            'title' => 'Add user',
            'route' => ['/user/people/create'],
            'parent' => 'user.index'
        ],
        'user.people' => [
            'title' => 'People',
            'route' => ['/user/people/index'],
            'parent' => 'user.index'
        ],
        'user.account_settings' => [
            'title' => 'Account settings',
            'route' => ['/user/default/settings'],
            'parent' => 'user.index'
        ]
    ]
];
