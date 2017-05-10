<?php

use app\models\ModuleDefinition;
use app\modules\user\Module;

return [
    'id' => 'user',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config
    ],
    'bootstrap' => function (\yii\base\Application $app) {
        if ($app instanceof \yii\web\Application) {
            $app->getUser()->loginUrl = ['/user/default/login'];
        }
    },
    'weight' => 123,

    'name' => 'User Managment',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'required' => true,

    'dependencies' => [
        'rbac'
    ],

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
