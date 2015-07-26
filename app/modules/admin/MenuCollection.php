<?php

namespace app\modules\admin;

use app\modules\admin\models\ModuleDefinition;
use yii\base\Object;
use yii\helpers\ArrayHelper;

class MenuCollection extends Object
{
    protected $items;

    /**
     * @var ModuleDefinition[]
     */
    public $definitions;

    public function init()
    {
        foreach ($this->definitions as $definition) {
            $this->addItems($definition);
        }
    }

    protected function checkItem($name)
    {
        if (!isset($this->items[$name]) && empty($this->items[$name])) {
            $this->items[$name] = [];
        }
    }

    protected function addItemChild($name, $parent, $item)
    {
        $this->checkItem($parent);
        $this->items[$parent]['items'][$name] = $item;
    }

    protected function addItem($name, $item)
    {
        $this->checkItem($name);
        $this->items[$name] = ArrayHelper::merge($this->items[$name], $item);
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ModuleDefinition $model
     */
    public function addItems($model)
    {
        foreach ($model->menu as $name => $item) {
            if (isset($item['parent'])) {
                $this->addItemChild($name, $item['parent'], $model->createMenuItem($item));
            } else {
                $this->addItem($name, $model->createMenuItem($item));
            }
        }
    }
}
