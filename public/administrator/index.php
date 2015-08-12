<?php

require(dirname(dirname(__DIR__)) . '/vendor/autoload.php');
require(dirname(dirname(__DIR__)) . '/vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(dirname(dirname(__DIR__)) . '/app/config/common.php'),
    require(dirname(dirname(__DIR__)) . '/app/config/admin.php')
);

$app = new yii\web\Application($config);
$app->run();
