<?php

$modules = require(__DIR__ . '/modules.php');
$migrations = [];

foreach ($modules as $id) {
    $alias = '@app/modules/' . $id . '/migrations';
    $migrations[] = $alias;
}

return [
    'title' => 'Anidesu',

    'cookieKey' => 'anidesu:app',

    'theme' => '\app\themes\site\Theme',

    'adminEmail' => 'admin@anidesu.ru',
    'contactEmail' => 'contact@anidesu.ru',

    'robotEmail' => 'robot@anidesu.ru',
    'robotName' => 'Anidesu Robot',

    'yandexVerification' => '',
    'googleVerification' => '',

    'googleAnalyticsID' => 'UA-58349645-1',
    'yandexMetrikaID' => '27862425',

    'yii.migrations' => $migrations
];
