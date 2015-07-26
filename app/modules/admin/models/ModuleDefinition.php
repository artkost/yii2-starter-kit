<?php

namespace app\modules\admin\models;

use app\modules\admin\Module;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class ModuleDefinition extends Model
{
    const PACKAGE_CORE = 'core';

    public $name;
    public $package = 'contrib';
    public $category = 'common';
    public $required = false;

    public $configure = false;
    public $dependencies = [];

    public $menu = [];

    public function createMenuItem($item)
    {
        return [
            'label' => Module::t($this->category, Html::encode($item['title'])),
            'url' => isset($item['route']) ? $item['route'] : false,
            'icon' => isset($item['icon']) ? $item['icon'] : false
        ];
    }
}
