<?php

namespace app\modules\page\admin\actions;

use Yii;
use yii\db\ActiveRecord;
use yii\web\HttpException;
use app\modules\page\actions\Action;

class BatchDeleteAction extends Action
{

    public function run()
    {
        $ids = Yii::$app->request->post('ids');

        if ($ids !== null) {
            $models = $this->findModel($ids);

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $models);
            }

            if (is_array($models)) {
                foreach ($models as $model) {
                    $model->delete();
                }
            } elseif ($models instanceof ActiveRecord) {
                $models->delete();
            }


            return $this->controller->redirect(['index']);
        } else {
            throw new HttpException(400);
        }
    }
} 
