<?php

namespace app\modules\comment\admin\actions;

use app\modules\comment\actions\Action;
use Yii;
use yii\web\HttpException;

class BatchDelete extends Action
{

    public function run()
    {
        $ids = Yii::$app->request->post('ids');

        if ($ids !== null) {
            $models = $this->findModel($ids);

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $models);
            }

            foreach ($models as $model) {
                $model->delete();
            }

            return $this->controller->redirect(['index']);
        } else {
            throw new HttpException(400);
        }
    }
} 