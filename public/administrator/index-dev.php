<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(dirname(dirname(__DIR__)) . '/vendor/autoload.php');
require(dirname(dirname(__DIR__)). '/vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(dirname(dirname(__DIR__)) . '/app/config/common.php'),
    require(dirname(dirname(__DIR__)) . '/app/config/admin.php')
);

define('ADMIN_PREFIX', str_replace(dirname(__DIR__), '',__DIR__ ));

(new yii\web\Application($config))->run();
