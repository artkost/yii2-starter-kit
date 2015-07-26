<?php

namespace app\modules\user\models;

use app\modules\user\Module;
use app\base\helpers\Security;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class Email
 * Email is the model that is used to change user email address.
 *
 * @property integer $user_id User ID
 * @property string $email E-mail
 * @property string $token Confirmation token
 *
 * @property User $user
 * @property User $identity
 */
class UserEmail extends ActiveRecord
{
	/**
	 * @var string Current e-mail address
	 */
	private $_oldEmail;

	/**
	 * @var self string Email model instance
	 */
	private $_model;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_email}}';
	}

	/**
	 * @return string Current e-mail address
	 */
	public function getOldEmail()
	{
		if ($this->_oldEmail === null) {
			$this->_oldEmail = $this->identity->email;
		}

		return $this->_oldEmail;
	}

	/**
     * Generates secure key.
     */
    public function generateToken()
    {
        $this->token = Security::generateExpiringRandomString();
    }

    /**
     * Check if token is valid.
     *
     * @return boolean true if token is valid
     */
    public function isValidToken()
    {
    	if (Security::isValidToken($this->token, Module::param('emailWithin', 14400)) === true) {
    		return ($this->_model = static::findOne(['token' => $this->token])) !== null;
    	}
    	return false;
    }

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			// E-mail
			['email', 'required'],
			['email', 'trim'],
			['email', 'email'],
			['email', 'string', 'max' => 100],
			['email', 'compare', 'compareAttribute' => 'oldEmail', 'operator' => '!=='],
			['email', 'unique', 'targetClass' => User::className()],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'email' => Module::t('model', 'New Email'),
			'oldEmail' => Module::t('model', 'Old Email'),
		];
	}

    /**
     * @return User
     */
    public function getIdentity()
    {
        return Yii::$app->user->identity;
    }

	/**
	 * @return User|null Related user
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            static::deleteAll(['user_id' => $this->identity->id]);

            $this->user_id = $this->identity->id;
            $this->generateToken();
            $this->send();

            return true;
        }

        return false;
    }

	/**
	 * Confirm email change.
	 *
	 * @return boolean true if email was successfully confirmed.
	 */
	public function confirm()
	{
		$model = $this->_model;
		$user = $model->user;
		$user->email = $model->email;

		return $user->save(false) && $model->delete();
	}

	/**
     * Send an email confirmation token.
     *
     * @return boolean true if email confirmation token was successfully sent
     */
    public function send()
    {
    	return Module::sendConfirmEmail($this);
    }
}
