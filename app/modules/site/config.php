<?php

use app\models\ModuleDefinition;
use app\modules\site\Module;
use samdark\webshell\Module as WebShellModule;

return [
    'id' => 'site',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config
//        'modules' => [
//            'webshell' => [
//                'class' => WebShellModule::className(),
//                'yiiScript' => Yii::getAlias('@root'). '/yii', // adjust path to point to your ./yii script
//            ],
//        ],

    ],
    'bootstrap' => function (\yii\base\Application $app) {
        $app->setComponents([
            'attachmentManager' => [
                'class' => 'artkost\attachment\Manager',
                'storageUrl' => '@web/storage',
                'storagePath' => '@webroot/storage',
                'attachmentFileTable' => '{{%attachment_file}}'
            ],
        ]);
    },
    'name' => 'System',
    'package' => ModuleDefinition::PACKAGE_CORE,
    'category' => Module::TRANSLATE_CATEGORY,
    'required' => true,

    'urlRules' => [
        '/' => 'site/default/index',
        'site/index' => 'site/default/index',
        'site/login' => 'site/default/login'
    ]
];
