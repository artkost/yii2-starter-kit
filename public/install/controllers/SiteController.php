<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $frameworkPath = Yii::getAlias('@vendor/yiisoft/yii2');

        require_once($frameworkPath . '/requirements/YiiRequirementChecker.php');
        $requirements = $frameworkPath . '/requirements/requirements.php';

        $requirementsChecker = new \YiiRequirementChecker();

        /**
         * Return the check results.
         * @return array|null check results in format:
         *
         * ```php
         * array(
         *     'summary' => array(
         *         'total' => total number of checks,
         *         'errors' => number of errors,
         *         'warnings' => number of warnings,
         *     ),
         *     'requirements' => array(
         *         array(
         *             ...
         *             'error' => is there an error,
         *             'warning' => is there a warning,
         *         ),
         *         ...
         *     ),
         * )
         * ```
         */
        $result = $requirementsChecker->checkYii()->check($requirements)->getResult();

        var_dump($result);

        return $this->render('index');
    }

}