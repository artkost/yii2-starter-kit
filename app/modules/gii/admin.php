<?php

use app\modules\admin\models\ModuleDefinition;

return [
    'name' => 'Code Generation',
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
