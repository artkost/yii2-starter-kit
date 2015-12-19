<?php

use app\models\ModuleDefinition;
use app\modules\gii\Module;

return [
    'id' => 'gii',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config
    ],

    'name' => 'Code Generator',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'required' => false,

    'menu' => [
        'gii.index' => [
            'title' => 'Code Generation',
            'weight' => -1,
            'icon' => 'fa-cog'
        ],
        'gii.model' => [
            'title' => 'Model Generator',
            'route' => ['/gii/default/view', 'id' => 'model'],
            'parent' => 'gii.index'
        ],
        'gii.crud' => [
            'title' => 'CRUD Generator',
            'route' => ['/gii/default/view', 'id' => 'crud'],
            'parent' => 'gii.index'
        ],
        'gii.controller' => [
            'title' => 'Controller Generator',
            'route' => ['/gii/default/view', 'id' => 'controller'],
            'parent' => 'gii.index'
        ],
        'gii.form' => [
            'title' => 'Form Generator',
            'route' => ['/gii/default/view', 'id' => 'form'],
            'parent' => 'gii.index'
        ],
        'gii.module' => [
            'title' => 'Module Generator',
            'route' => ['/gii/default/view', 'id' => 'module'],
            'parent' => 'gii.index'
        ],
        'gii.extension' => [
            'title' => 'Extension Generator',
            'route' => ['/gii/default/view', 'id' => 'extension'],
            'parent' => 'gii.index'
        ]
    ]
];
