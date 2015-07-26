<?php

namespace app\modules\admin;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    const PARAM_ROOT = 'admin';
    const TRANSLATE_CATEGORY = 'admin';

    use ModuleParamTrait;
    use TranslatableTrait;

    protected static $menu;

    public function init()
    {
        parent::init();

        $this->set('definitionManager', [
            'class' => DefinitionManager::className()
        ]);
    }

    /**
     * @return MenuCollection
     */
    public function getMenu()
    {
        if (self::$menu == null) {
            self::$menu = Yii::createObject([
                'class' => MenuCollection::className(),
                'definitions' => $this->get('definitionManager')->getModulesDefinitions()
            ]);
        }

        return self::$menu;
    }
}
