<?php

namespace app\modules\api;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;

class Module extends \yii\base\Module
{
    const PARAM_ROOT = 'api';
    const TRANSLATE_CATEGORY = 'api';

    use ModuleParamTrait;
    use TranslatableTrait;
}
