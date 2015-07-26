<?php

use app\modules\admin\models\ModuleDefinition;
use app\modules\rbac\Module;

return [
    'name' => 'Role Based Access Rights',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => true,

    'menu' => [
        'rbac.index' => [
            'title' => 'Access Rights',
            'icon' => 'fa-group',
        ],
        'rbac.permissions' => [
            'title' => 'Permissions',
            'route' => ['/rbac/permissions/index'],
            'parent' => 'rbac.index'
        ],
        'rbac.roles' => [
            'title' => 'Roles',
            'route' => ['/rbac/roles/index'],
            'parent' => 'rbac.index'
        ]
    ]
];
