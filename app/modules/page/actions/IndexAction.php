<?php

namespace app\modules\page\actions;

use Closure;
use yii\data\ActiveDataProvider;

class IndexAction extends Action
{

    public function run()
    {
        /** @var ActiveRecordInterface $modelClass */
        $modelClass = $this->modelClass;

        if ($this->checkAccess !== null) {
            return call_user_func($this->checkAccess, $this, null);
        }

        if ($this->query instanceof Closure) {
            $fn = $this->query;
            $query = $fn();
        } else {
            $query = $modelClass::find()->published();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->controller->module->recordsPerPage
            ]
        ]);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
} 
