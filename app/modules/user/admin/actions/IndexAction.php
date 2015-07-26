<?php

namespace app\modules\user\admin\actions;

use Yii;
use yii\helpers\ArrayHelper;

class IndexAction extends Action
{

    public $viewFile = 'index';

    public $roleArray;
    public $statusArray;

    public function run()
    {
        $searchModel = Yii::createObject($this->modelClass);
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $roles = [];
        if ($this->roleArray !== null) {
            $roles =  call_user_func($this->roleArray, $this);
        }
        $roleArray = ArrayHelper::map($roles, 'name', 'description');

        $statusArray = [];
        if ($this->statusArray !== null) {
            $statusArray =  call_user_func($this->statusArray, $this);
        }

        return $this->render(compact([
            'dataProvider',
            'searchModel',
            'roleArray',
            'statusArray'
        ]));
    }
}
