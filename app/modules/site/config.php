<?php

use app\models\ModuleDefinition;
use app\modules\site\Module;

return [
    'id' => 'site',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config
    ],

    'name' => 'System',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => true,

    'urlRules' => [
        '/' => 'site/default/index',
        'site/index' => 'site/default/index'
    ]
];
