<?php

namespace app\modules\comment\admin\actions;

use app\modules\comment\actions\Action;
use yii\web\ServerErrorHttpException;

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

        return $this->redirect(['index']);
    }
} 