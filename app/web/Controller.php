<?php

namespace app\web;

use Yii;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller
{
    public $layout = '@app/views/layouts/html';

    protected function access($permissionName, $params = [], $allowCaching = true)
    {
        if (Yii::$app->user->can($permissionName, $params, $allowCaching)) {
            return true;
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * @param $view
     * @param array $params
     * @return string
     */
    protected function renderOrAjax($view, $params = [])
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax($view, $params);
        } else {
            return $this->render($view, $params);
        }
    }
}