<?php

namespace app\modules\gii;

use yii\gii\Module as GiiModule;

class Module extends GiiModule
{

    public function init()
    {
        $this->controllerNamespace = 'yii\gii\controllers';

        parent::init();
    }
}
