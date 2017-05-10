<?php

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;


class InstallController extends Controller
{
    /**
     * Installs starter kit.
     */
    public function actionIndex()
    {
        $this->stdout("Executing hourly tasks:\n\n", Console::FG_YELLOW);
        $this->stdout("\n\nAll cron tasks finished.\n\n", Console::FG_GREEN);
        return self::EXIT_CODE_NORMAL;
    }
}