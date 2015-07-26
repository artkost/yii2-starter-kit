<?php

namespace app\modules\comment;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;

class Module extends \yii\base\Module
{
    const PARAM_ROOT = 'film';
    const TRANSLATE_CATEGORY = 'film';

    use ModuleParamTrait;
    use TranslatableTrait;

    /**
     * @var array of models added by default in migrations
     */
    public $defaultModels = [];
} 
