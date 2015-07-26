<?php

namespace app\modules\page\admin\actions;

use app\modules\page\actions\Action;
use app\modules\page\models\PageModel;
use Yii;

class IndexAction extends Action
{
    public function run()
    {
        $modelClass = $this->modelClass;

        $searchModel = new $modelClass();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $statusArray = $modelClass::statusLabels();
        $modelArray = PageModel::getModelsArray();

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'statusArray' => $statusArray,
            'modelArray' => $modelArray
        ]);
    }
} 