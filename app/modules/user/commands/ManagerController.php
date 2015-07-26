<?php

namespace app\modules\user\commands;

use app\base\helpers\Security;
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
            $this->insertUser($username, $email, $password);

            $this->stdout('Added user with:' . PHP_EOL);

            $this->stdout('ID:', Console::FG_GREY);
            $this->stdout(Yii::$app->db->lastInsertID . PHP_EOL, Console::FG_YELLOW);
            $this->stdout('Username:', Console::FG_GREY);
            $this->stdout($username . PHP_EOL, Console::FG_YELLOW);
            $this->stdout('Email:', Console::FG_GREY);
            $this->stdout($email . PHP_EOL, Console::FG_YELLOW);
            $this->stdout('Password:', Console::FG_GREY);
            $this->stdout($password . PHP_EOL, Console::FG_YELLOW);
        }

        if ($name && $surname && $sex) {
            $this->insertProfile($name, $surname, $sex);
        }

    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return int
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    private function insertUser($username = 'admin', $email = 'admin@demo.com', $password = 'admin12345')
    {
        $time = time();
        $passwordHash = Yii::$app->security->generatePasswordHash($password);
        $authKey = Yii::$app->security->generateRandomString();
        $secureKey = Security::generateExpiringRandomString();

        return Yii::$app->db->createCommand()->insert(User::tableName(), [
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash,
            'auth_key' => $authKey,
            'secure_key' => $secureKey,
            'status_id' => User::STATUS_ACTIVE,
            'created_at' => $time,
            'updated_at' => $time
        ])->execute();
    }

    /**
     * @param $name
     * @param $surname
     * @param int $sex
     * @return int
     * @throws \yii\db\Exception
     */
    private function insertProfile($name = 'User', $surname = 'Name', $sex = 1)
    {
        return Yii::$app->db->createCommand()->insert(UserProfile::tableName(), [
            'user_id' => Yii::$app->db->lastInsertID,
            'name' => $name,
            'surname' => $surname,
            'sex' => $sex,
        ])->execute();
    }

}
