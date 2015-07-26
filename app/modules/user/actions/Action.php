<?php

namespace app\modules\user\actions;

use yii\base\InvalidConfigException;

class Action extends \yii\base\Action
{
    /**
     * @var string class name of the model which will be handled by this action.
     * The model class must implement [[ActiveRecordInterface]].
     * This property must be set.
     */
    public $modelClass;

    public $viewFile;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$modelClass must be set.');
        }
    }

    public function render($params = [])
    {
        return $this->controller->render($this->viewFile, $params);
    }

}
