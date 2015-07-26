<?php

use app\modules\admin\models\ModuleDefinition;
use app\modules\admin\Module;

return [
    'name' => Module::t('info', 'Administration'),
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => true,

    'configure' => ['/admin/system/settings'],

    'menu' => [
        'admin.index' => [
            'title' => Module::t('info', 'Administration'),
            'weight' => 10,
            'icon' => 'fa-cog'
        ],
        'admin.dashboard' => [
            'title' => Module::t('info', 'Dashboard'),
            'route' => ['/admin/default/index'],
            'parent' => 'admin.index'
        ],
        'admin.modules' => [
            'title' => Module::t('info', 'Modules'),
            'route' => ['/admin/default/modules'],
            'parent' => 'admin.index'
        ],
        'admin.preview' => [
            'title' => Module::t('info', 'Preview'),
            'route' => ['/admin/default/preview'],
            'parent' => 'admin.index'
        ]
    ]
];
