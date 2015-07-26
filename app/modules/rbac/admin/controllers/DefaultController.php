<?php

namespace app\modules\rbac\admin\controllers;

use app\modules\admin\components\Controller;
use Yii;

/**
 * Roles controller.
 */
class DefaultController extends Controller
{

    public function indexAction()
    {
        $this->render('index');
    }
}