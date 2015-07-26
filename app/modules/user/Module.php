<?php

namespace app\modules\user;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use Yii;
use yii\base\Model;

class Module extends \yii\base\Module
{
    const PARAM_ROOT = 'user';
    const TRANSLATE_CATEGORY = 'user';

    use ModuleParamTrait;
    use TranslatableTrait;

    /**
     * @var boolean If true after registration user will be required to confirm his e-mail address.
     */
    public $requireEmailConfirmation = true;

    /**
     * @var integer The time before a sent activation token becomes invalid.
     * By default is 24 hours.
     */
    public $activationWithin = 86400; // 24 hours

    /**
     * @var integer The time before a sent recovery token becomes invalid.
     * By default is 4 hours.
     */
    public $recoveryWithin = 14400; // 4 hours

    /**
     * @var integer The time before a sent confirmation token becomes invalid.
     * By default is 4 hours.
     */
    public $emailWithin = 14400; // 4 hours

    /**
     * @var integer Users per page
     */
    public $recordsPerPage = 10;

    public $avatarDefaultUrl = '';

    public static function sendSignUpEmail(Model $model)
    {
        if (Module::param('requireEmailConfirmation', false)) {
            return self::getInstance()
                ->getMail()
                ->compose('signup', ['model' => $model])
                ->setTo($model->email)
                ->setSubject(Module::t('mail', 'EMAIL_SUBJECT_SIGNUP') . ' ' . Yii::$app->name)
                ->send();
        }

        return false;
    }

    public static function sendRecoveryEmail(Model $model)
    {
        return self::getInstance()
            ->getMail()
            ->compose('recovery', ['model' => $model])
            ->setTo($model->email)
            ->setSubject(Module::t('mail', 'EMAIL_SUBJECT_RECOVERY') . ' ' . Yii::$app->name)
            ->send();
    }

    public static function sendConfirmEmail(Model $model)
    {
        return self::getInstance()
            ->getMail()
            ->compose('email', ['model' => $model])
            ->setTo($model->email)
            ->setSubject(Module::t('mail', 'EMAIL_SUBJECT_CHANGE') . ' ' . Yii::$app->name)
            ->send();
    }

    public static function avatarDefaultUrl()
    {
        return Yii::$app->assetManager->publish(self::getInstance()->avatarDefaultUrl)[1];
    }

} 
