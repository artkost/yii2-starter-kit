<?php

namespace app\base;

use Yii;
use yii\helpers\ArrayHelper;

trait ModuleParamTrait
{
    public static function param($name, $default)
    {
        $key = self::PARAM_ROOT . '.' . $name;

        return ArrayHelper::getValue(Yii::$app->params, $key, $default);
    }
}
