<?php

require(dirname(dirname(__DIR__)) . '/vendor/autoload.php');
require(dirname(dirname(__DIR__)). '/vendor/yiisoft/yii2/Yii.php');

(new yii\web\Application(require(__DIR__ . '/config/web.php')))->run();
