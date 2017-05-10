<?php

namespace app\modules\user\models;

use artkost\attachment\behaviors\AttachBehavior;
use app\modules\user\Module;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class Profile
 * @package app\modules\users\models
 *
 * @property integer $user_id User ID
 * @property integer $avatar_id Avatar
 * @property string $name Name
 * @property string $surname Surname
 * @property boolean $sex
 *
 * @property User $user User
 * @property UserAvatarFile $avatar Avatar file
 */
class UserProfile extends ActiveRecord
{
    const SEX_MALE = 0;
    const SEX_FEMALE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
//@TODO move to proper place,
//        $behaviors[] = [
//            'class' => AttachBehavior::className(),
//            'models' => [
//                'avatar' => [
//                    'class' => UserAvatarFile::className()
//                ]
//            ]
//        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public static function findByUserId($id)
    {
        return static::findOne(['user_id' => $id]);
    }

    /**
     * @return array sex type.
     */
    public static function sexLabels()
    {
        return [
            self::SEX_MALE => Module::t('model', 'Male'),
            self::SEX_FEMALE => Module::t('model', 'Female')
        ];
    }

    /**
     * @return string
     */
    public function getSexName()
    {
        return self::sexLabels()[$this->sex];
    }

    /**
     * @return string User full name
     */
    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return UserAvatarFile
     */
    public function getAvatar()
    {
        return $this->hasOneAttachment('avatar', ['id' => 'avatar_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname'], 'string'],
            [['avatar_id', 'sex'], 'integer'],

            // Name
            ['name', 'match', 'pattern' => '/^[a-zа-яё]+$/iu'],
            // Surname
            ['surname', 'match', 'pattern' => '/^[a-zа-яё]+(-[a-zа-яё]+)?$/iu'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('model', 'Name'),
            'surname' => Module::t('model', 'Surname')
        ];
    }

    /**
     * @return UserProfile|null Profile user
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('profile');
    }
}
