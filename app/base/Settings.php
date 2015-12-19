<?php

namespace app\base;

use yii\base\Component;

//загружаем конфиг из файла
//загружаем конфиг из хранилища

/**
 * Class Settings
 * @package app\base
 */
class Settings extends Component
{

    public $basePath = '@app/config/params.php';

    public function init()
    {

    }
}