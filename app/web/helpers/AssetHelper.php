<?php

namespace app\web\helpers;

use Yii;

class AssetHelper {

    private static $_published;

    public static function publish($path, $options = [])
    {
        if (!isset(self::$_published[$path])) {
            self::$_published[$path] = Yii::$app->assetManager->publish($path, $options);
        }

        return self::$_published[$path];
    }
}
