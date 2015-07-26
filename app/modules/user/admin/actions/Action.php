<?php

namespace app\modules\user\admin\actions;

use app\modules\user\actions\Action as Base;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;

class Action extends Base
{

    public $findModel;

    /**
     * Find model by ID
     *
     * @param integer $id User ID
     *
     * @throws NotFoundHttpException 404 error if user was not found
     *
     * @return ActiveRecordInterface
     */
    public function findModel($id)
    {
        if ($this->findModel !== null) {
            return call_user_func($this->findModel, $id, $this);
        }

        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $this->modelClass;
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }

        if (isset($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException("Model not found: $id");
        }
    }
}
