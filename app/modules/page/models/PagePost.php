<?php

namespace app\modules\page\models;

class PagePost extends PostBase
{

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new PagePostQuery(get_called_class());
    }
}