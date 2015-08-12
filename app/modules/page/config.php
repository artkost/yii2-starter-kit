<?php

use app\models\ModuleDefinition;
use app\modules\page\Module;

return [
    'id' => 'page',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config
    ],

    'name' => 'Pages Content',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => false,

    'menu' => [
        'page.index' => [
            'title' => 'Pages',
            'icon' => 'fa-file-text',
        ],
        'page.content' => [
            'title' => 'Content',
            'route' => ['/page/content/index'],
            'parent' => 'page.index'
        ],
        'page.create' => [
            'title' => 'Add Page',
            'route' => ['/page/content/create'],
            'parent' => 'page.index'
        ]
    ]
];
