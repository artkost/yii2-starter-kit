<?php

use app\models\ModuleDefinition;
use app\modules\admin\Module;

return [
    'id' => 'admin',
    'class' => Module::className(),

    'config' => [
        //set module config, like it loaded from default config
    ],

    'name' => Module::t('info', 'Administration'),
    'description' => Module::t('info', 'Administration Panel Module'),
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => true,
    'version' => '1.0',

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
            'route' => ['/admin/modules/index'],
            'parent' => 'admin.index'
        ],
        'admin.preview' => [
            'title' => Module::t('info', 'Preview'),
            'route' => ['/admin/default/preview'],
            'parent' => 'admin.index'
        ]
    ]
];
