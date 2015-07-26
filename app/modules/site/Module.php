<?php

namespace app\modules\site;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;

class Module extends \yii\base\Module
{
    const PARAM_ROOT = 'site';
    const TRANSLATE_CATEGORY = 'site';

    use ModuleParamTrait;
    use TranslatableTrait;
}
