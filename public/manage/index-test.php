<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_ENV') or define('YII_ENV', 'test');

require(dirname(dirname(__DIR__)) . '/vendor/autoload.php');
require(dirname(dirname(__DIR__)) . '/vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(dirname(dirname(__DIR__)) . '/app/config/common.php'),
    require(dirname(dirname(__DIR__)) . '/app/tests/codeception/config/acceptance.php')
);

define('ADMIN_PREFIX', str_replace(dirname(__DIR__), '',__DIR__ ));

(new yii\web\Application($config))->run();
