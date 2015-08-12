<?php

//$modules = require(__DIR__ . '/modules.php');
$migrations = [];

//foreach ($modules as $id) {
//    $alias = '@app/modules/' . $id . '/migrations';
//    $migrations[] = $alias;
//}

return [
    'title' => 'Anidesu',

    'cookieKey' => 'anidesu:app',

    'theme' => '\app\themes\site\Theme',

    'yii.migrations' => $migrations,

    'modules.path' => ['@app/modules', '@modules'],

    'installed' => true
];
