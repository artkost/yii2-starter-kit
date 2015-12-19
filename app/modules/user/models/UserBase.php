<?php

namespace app\modules\user\models;

use app\base\helpers\SecurityHelper;
use app\modules\user\models\query\UserQuery;
use app\modules\user\Module;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\modules\users\models
 * User model.
 *
 * @property integer $id ID
 * @property string $username Username
 * @property string $email E-mail
 * @property string $password_hash Password hash
 * @property string $auth_key Authentication key
 * @property string $secure_key Secure key
 * @property integer $status_id Status
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 *
 * @property UserProfile $profile Profile
 */
class UserBase extends ActiveRecord implements IdentityInterface
{
    /** Inactive status */
    const STATUS_INACTIVE = 0;
    /** Active status */
    const STATUS_ACTIVE = 1;
    /** Banned status */
    const STATUS_BANNED = 2;
    /** Deleted status */
    const STATUS_DELETED = 3;

    /**
     * Default role
     */
    const ROLE_DEFAULT = 'user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Find users by IDs.
     *
     * @param array $ids User IDs
     * @param null $scope Scope
     *
     * @return array|\yii\db\ActiveRecord[] Users
     */
    public static function findIdentities($ids, $scope = null)
    {
        $query = static::find()->where(['id' => $ids]);

        if ($scope !== null) {
            if (is_array($scope)) {
                foreach ($scope as $value) {
                    $query->$value();
                }
            } else {
                $query->$scope();
            }
        }

        return $query->all();
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * Find model by username.
     *
     * @param string $username Username
     * @param string $scope Scope
     *
     * @return array|\yii\db\ActiveRecord[] User
     */
    public static function findByUsername($username, $scope = null)
    {
        $query = static::find()->where(['username' => $username]);

        return static::applyScope($query, $scope)->one();
    }

    /**
     * Find model by email.
     *
     * @param string $email Email
     * @param string $scope Scope
     *
     * @return array|\yii\db\ActiveRecord[] User
     */
    public static function findByEmail($email, $scope = null)
    {
        $query = static::find()->where(['email' => $email]);

        return static::applyScope($query, $scope)->one();
    }

    /**
     * Find model by token.
     *
     * @param string $token Token
     * @param string $scope Scope
     *
     * @return array|\yii\db\ActiveRecord[] User
     */
    public static function findByToken($token, $scope = null)
    {
        $query = static::find()->where(['secure_key' => $token]);

        return static::applyScope($query, $scope)->one();
    }

    /**
     * @param $query
     * @param null $scope
     * @return ActiveQuery
     */
    public static function applyScope($query, $scope = null)
    {
        if ($scope !== null) {
            if (is_array($scope)) {
                foreach ($scope as $value) {
                    $query->$value();
                }
            } else {
                $query->$scope();
            }
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function getToken()
    {
        return $this->secure_key;
    }

    /**
     * Auth Key validation.
     *
     * @param string $authKey
     *
     * @return boolean
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Password validation.
     *
     * @param string $password
     *
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return string Human readable created date
     */
    public function getCreated()
    {
        return Yii::$app->formatter->asDate($this->created_at);
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('model', 'Username'),
            'email' => Module::t('model', 'Email'),
            'status_id' => Module::t('model', 'Status'),
            'created_at' => Module::t('model', 'Created At'),
            'updated_at' => Module::t('model', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this
                    ->setDefaultStatus()
                    ->generateAuthKey()
                    ->generateToken();
            }
            return true;
        }
        return false;
    }

    /**
     * @return UserProfile|null User profile
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setDefaultStatus($status = self::STATUS_ACTIVE)
    {
        if (Module::param('requireEmailConfirmation', false)) {
            $status = self::STATUS_INACTIVE;
        }

        // Set default status
        if (!$this->status_id) {
            $this->status_id = $status;
        }

        return $this;
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);

        return $this;
    }

    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();

        return $this;
    }

    /**
     * Generates secure key.
     */
    public function generateToken()
    {
        $this->secure_key = SecurityHelper::generateExpiringRandomString();

        return $this;
    }

    /**
     * Activates user account.
     *
     * @return boolean true if account was successfully activated
     */
    public function activateAndSave()
    {
        $this->status_id = self::STATUS_ACTIVE;

        return $this->generateToken()->save(false);
    }

    /**
     * Recover password.
     *
     * @param string $password New Password
     *
     * @return boolean true if password was successfully recovered
     */
    public function recoveryAndSave($password)
    {
        return $this->setPassword($password)->generateToken()->save(false);
    }

    /**
     * Change user password.
     *
     * @param string $password Password
     *
     * @return boolean true if password was successfully changed
     */
    public function changePasswordAndSave($password)
    {
        return $this->setPassword($password)->save(false);
    }
}
