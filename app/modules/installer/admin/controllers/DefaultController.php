<?php

namespace app\modules\installer\admin\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = '//guest';

    public function actionIndex()
    {
        return $this->render('index');
    }
}