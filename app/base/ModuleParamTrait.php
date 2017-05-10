<?php

namespace app\base;

use Yii;
use yii\helpers\ArrayHelper;

trait ModuleParamTrait
{
    /**
     * Allows to load params from $app->params by module namespace
     * For ex. `MySuperModule.myparam`
     * @param $name
     * @param $default
     * @return mixed
     */
    public static function param($name, $default)
    {
        $key = self::PARAM_ROOT . '.' . $name;

        return ArrayHelper::getValue(Yii::$app->params, $key, $default);
    }
}
