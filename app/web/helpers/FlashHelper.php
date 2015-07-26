<?php

namespace app\web\helpers;

use Yii;

class FlashHelper
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public static $alertTypes = [
        'error' => 'danger',
        'danger' => 'danger',
        'success' => 'success',
        'info' => 'info',
        'warning' => 'warning'
    ];

    public static function error($value, $removeAfterAccess = true)
    {
        self::flash('error', $value, $removeAfterAccess);
    }

    public static function danger($value, $removeAfterAccess = true)
    {
        self::flash('danger', $value, $removeAfterAccess);
    }

    public static function success($value, $removeAfterAccess = true)
    {
        self::flash('success', $value, $removeAfterAccess);
    }

    public static function info($value, $removeAfterAccess = true)
    {
        self::flash('info', $value, $removeAfterAccess);
    }

    public static function warning($value, $removeAfterAccess = true)
    {
        self::flash('warning', $value, $removeAfterAccess);
    }

    private static function flash($type, $value, $removeAfterAccess)
    {
        Yii::$app->session->setFlash($type, $value, $removeAfterAccess);
    }
}
