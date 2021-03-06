<?php

use app\models\ModuleDefinition;
use app\modules\news\Module;

return [
    'id' => 'news',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config
    ],

    'name' => 'News',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => false,

    'urlRules' => [
        'news' => 'news/default/index',
        'news/tag/<name>' => 'news/default/tag',
        'news/<url>' => 'news/default/view',
    ],

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
