<?php

use app\models\ModuleDefinition;
use app\modules\installer\Module;

return [
    'id' => 'installer',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config
    ],

    'name' => 'System installer',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => false,

    'urlRules' => [
    ]
];
