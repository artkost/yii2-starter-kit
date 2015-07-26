<?php

return [
    'class' => 'yii\rbac\DbManager',
    'itemTable' => '{{%rbac_item}}',
    'itemChildTable' => '{{%rbac_item_child}}',
    'assignmentTable' => '{{%rbac_assignment}}',
    'ruleTable' => '{{%rbac_rule}}',
    'defaultRoles' => ['guest'],
    'cache' => 'cache'
];
