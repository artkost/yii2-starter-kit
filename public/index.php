<?php

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__ ). '/vendor/yiisoft/yii2/Yii.php');
require(dirname(__DIR__) . '/app/web/Application.php');

$config = yii\helpers\ArrayHelper::merge(
    require(dirname(__DIR__) . '/app/config/common.php'),
    require(dirname(__DIR__) . '/app/config/web.php')
);

(new app\web\Application($config))->run();
