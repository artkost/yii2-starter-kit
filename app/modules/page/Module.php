<?php

namespace app\modules\page;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;

class Module extends \yii\base\Module
{
    const PARAM_ROOT = 'page';
    const TRANSLATE_CATEGORY = 'page';

    use ModuleParamTrait;
    use TranslatableTrait;
}
