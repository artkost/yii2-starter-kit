<?php

use app\models\ModuleDefinition;
use app\modules\rbac\Module;

return [
    'id' => 'rbac',
    'class' => Module::className(),
    'config' => [
        //set module config, like it loaded from default config dir
    ],
    'bootstrap' => function (\yii\base\Application $app) {
        $app->setComponents([
            'authManager' => [
                'class' => 'yii\rbac\DbManager',
                'itemTable' => '{{%rbac_item}}',
                'itemChildTable' => '{{%rbac_item_child}}',
                'assignmentTable' => '{{%rbac_assignment}}',
                'ruleTable' => '{{%rbac_rule}}',
                'defaultRoles' => Module::DEFAULT_ROLES,
                'cache' => 'cache'
            ],
            'user' => [
                'class' => 'app\modules\rbac\components\User',
                'identityClass' => 'app\models\User'
            ]
        ]);
    },

    'weight' => 100,

    'name' => 'Access Rights',
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
