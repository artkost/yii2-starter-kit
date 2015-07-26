<?php

namespace app\base\helpers;

use Yii;

class Security
{
    /**
     * Generate a random key with time suffix.
     * @return string Random key
     */
    public static function generateExpiringRandomString()
    {
        return Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Check if token is not expired.
     *
     * @param string $token Token that must be validated
     * @param integer $duration Time during token is valid
     * @return boolean true if token is not expired
     */
    public static function isValidToken($token, $duration)
    {
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return ($timestamp + $duration > time());
    }

    /**
     * @param string $str String to be encrypted
     *
     * @return int Encrypted string
     */
    public static function crc32($str)
    {
        return sprintf("%u", crc32($str));
    }
}
