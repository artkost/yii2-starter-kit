<?php

use app\modules\admin\Module;

$managePermissions = [
    'viewAdminPanel' => Module::t('rules', 'View Admin Panel')
];

foreach (Yii::$app->modules as $id => $module) {
    $managePermissions['admin'. ucfirst($id) . 'Module'] = Module::t('rules', 'Manage ' . ucfirst($id) . ' Module');
}

return [
    'permissions' => $managePermissions,
    'roles' => [
        'adminManager' => Module::t('rules', 'Admin Manager'),
    ],
    'assignments' => [
        'adminManager' => array_keys($managePermissions)
    ]
];
