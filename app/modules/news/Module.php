<?php

namespace app\modules\news;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;

class Module extends \yii\base\Module
{
    const PARAM_ROOT = 'news';
    const TRANSLATE_CATEGORY = 'news';

    use ModuleParamTrait;
    use TranslatableTrait;
}
