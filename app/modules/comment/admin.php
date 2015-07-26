<?php

use app\modules\admin\models\ModuleDefinition;
use app\modules\comment\Module;

return [
    'name' => 'Comments System',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => false,

    'menu' => [
        'comment.index' => [
            'title' => 'Comments',
            'icon' => 'fa-comments',
        ],
        'comment.content' => [
            'title' => 'Content',
            'route' => ['/comment/content/index'],
            'parent' => 'comment.index'
        ],
        'comment.moderate' => [
            'title' => 'Moderate',
            'route' => ['/comment/content/moderate'],
            'parent' => 'comment.index'
        ],
        'comment.reports' => [
            'title' => 'Reports',
            'route' => ['/comment/content/reports'],
            'parent' => 'comment.index'
        ]
    ]
];
