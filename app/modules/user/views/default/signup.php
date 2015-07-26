<?php

/**
 * Signup page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\modules\user\models\User $user Model
 * @var \app\modules\user\models\UserProfile $profile Profile
 */

use app\modules\attachment\widgets\FileAPI as FileAPIWidget;
use app\modules\user\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Module::t('user', 'Sign up');
$this->params['breadcrumbs'] = [
    $this->title
]; ?>
<?php $form = ActiveForm::begin(
    ['options' => ['class' => 'center']]
); ?>
    <fieldset class="registration-form">
        <?= $form->field($profile, 'name')->textInput(
            ['placeholder' => $profile->getAttributeLabel('name')]
        )->label(false) ?>
        <?= $form->field($profile, 'surname')->textInput(
            ['placeholder' => $profile->getAttributeLabel('surname')]
        )->label(false) ?>
        <?= $form->field($user, 'username')->textInput(
            ['placeholder' => $user->getAttributeLabel('username')]
        )->label(false) ?>
        <?= $form->field($user, 'email')->textInput(
            ['placeholder' => $user->getAttributeLabel('email')]
        )->label(false) ?>
        <?= $form->field($user, 'password')->passwordInput(
            ['placeholder' => $user->getAttributeLabel('password')]
        )->label(false) ?>
        <?= $form->field($user, 'repassword')->passwordInput(
            ['placeholder' => $user->getAttributeLabel('repassword')]
        )->label(false) ?>
        <?= $form->field($profile, 'avatar_id')->widget(
            FileAPIWidget::className(),
            [
                'settings' => [
                    'url' => ['fileapi-upload']
                ],
                'crop' => true,
                'cropResizeWidth' => 100,
                'cropResizeHeight' => 100
            ]
        )->label(false) ?>
        <?= Html::submitButton(
            Module::t('user', 'Register account'),
            [
                'class' => 'btn btn-success btn-large pull-right'
            ]
        ) ?>
        <?= Html::a(Module::t('user', 'Resend email'), ['resend']); ?>
    </fieldset>
<?php ActiveForm::end(); ?>
