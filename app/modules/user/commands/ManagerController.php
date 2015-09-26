<?php

namespace app\modules\user\commands;

use app\modules\user\models\User;
use app\modules\user\models\UserProfile;
use app\modules\user\Module;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * User console controller.
 */
class ManagerController extends Controller
{

    public function actionCreate()
    {
        $username = $this->prompt(Module::t('console', 'Username:'));
        $email = $this->prompt(Module::t('console', 'Email:'));
        $password = $this->prompt(Module::t('console', 'Password:'));
        $name = $this->prompt(Module::t('console', 'First Name:'));
        $surname = $this->prompt(Module::t('console', 'Last Name:'));
        $sex = $this->confirm(Module::t('console', 'Male ?'), 1);

        if ($username && $email && $password) {
            $user = $this->insertUser($username, $email, $password);
            $id = $user->id;

            $this->stdout('Added user with:' . PHP_EOL);
            $this->stdout('ID:', Console::FG_GREY);
            $this->stdout($id . PHP_EOL, Console::FG_YELLOW);
            $this->stdout('Username:', Console::FG_GREY);
            $this->stdout($username . PHP_EOL, Console::FG_YELLOW);
            $this->stdout('Email:', Console::FG_GREY);
            $this->stdout($email . PHP_EOL, Console::FG_YELLOW);
            $this->stdout('Password:', Console::FG_GREY);
            $this->stdout($password . PHP_EOL, Console::FG_YELLOW);

            if ($id && $name && $surname && $sex) {
                $this->insertProfile($id, $name, $surname, $sex);
            }
        }
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    private function insertUser($username = 'admin', $email = 'admin@demo.com', $password = 'admin12345')
    {
        $user = new User([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);

        $user->activateAndSave();

        return $user;
    }

    /**
     * @param $id
     * @param $name
     * @param $surname
     * @param int $sex
     * @return int
     * @throws \yii\db\Exception
     */
    private function insertProfile($id, $name = 'User', $surname = 'Name', $sex = 1)
    {
        $profile = new UserProfile([
            'user_id' => $id,
            'name' => $name,
            'surname' => $surname,
            'sex' => $sex,
        ]);

        return $profile->save();
    }
}
