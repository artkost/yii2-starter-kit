<?php

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__ ). '/vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(dirname(__DIR__) . '/app/config/common.php'),
    require(dirname(__DIR__) . '/app/config/web.php')
);

(new yii\web\Application($config))->run();
