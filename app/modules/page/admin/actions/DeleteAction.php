<?php

namespace app\modules\page\admin\actions;

use yii\web\ServerErrorHttpException;
use app\modules\page\actions\Action;

class DeleteAction extends Action
{
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        return $this->controller->redirect(['index']);
    }
} 