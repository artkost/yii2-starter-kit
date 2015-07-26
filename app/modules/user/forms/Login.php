<?php

namespace app\modules\user\forms;

use app\modules\user\Module;
use app\modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 *
 * @property string $username Username
 * @property string $password Password
 * @property boolean $rememberMe Remember me
 */
class Login extends Model
{
    /**
     * @var string $username Username
     */
    public $username;

    /**
     * @var string $password Password
     */
    public $password;

    /**
     * @var boolean rememberMe Remember me
     */
    public $rememberMe = true;

    /**
     * @var User|boolean User instance
     */
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['username', 'password'], 'required'],
            // Password
            ['password', 'validatePassword'],
            // Remember Me
            ['rememberMe', 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('model', 'Username'),
            'password' => Module::t('model', 'Password'),
            'rememberMe' => Module::t('model', 'Remember me')
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->$attribute)) {
                $this->addError($attribute, Module::t('model', 'Invalid username or password'));
            }
        }
    }

    /**
     * Finds user by username.
     *
     * @return User|boolean User instance
     */
    protected function getUser()
    {
        if ($this->_user === false) {
            $user = User::findByUsername($this->username, 'active');

            if ($user !== null) {
                $this->_user = $user;
            }
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }
}
