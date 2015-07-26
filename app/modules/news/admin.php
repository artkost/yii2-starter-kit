<?php

use app\modules\admin\models\ModuleDefinition;
use app\modules\rbac\Module;

return [
    'name' => 'News',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => false,

    'dependencies' => [
        'page'
    ],

    'menu' => [
        'news.create' => [
            'title' => 'Add News Post',
            'route' => ['/news/content/create'],
            'weight' => 100,
            'parent' => 'page.index'
        ]
    ]
];
