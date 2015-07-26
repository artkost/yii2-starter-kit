<?php
use app\modules\user\Module;
use app\themes\admin\Theme;
use yii\helpers\Html;

/**
 * @var $roleArray string[]
 * @var $statusArray string[]
 */

$box->beginBody();
?>

<?= $form->field($user, 'username') ?>
<?= $form->field($user, 'email') ?>

<?= $form->field($user, 'password')->passwordInput() ?>
<?= $form->field($user, 'repassword')->passwordInput() ?>

<?= $form->field($user, 'status_id')->checkboxList(
    $statusArray,
    [
        'prompt' => Theme::t('user', 'Select status')
    ]
) ?>

<?= $form->field($user, 'roles')->checkboxList($roleArray) ?>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $user->isNewRecord ? Theme::t('user', 'Create user') : Theme::t('user', 'Update user'),
    [
        'class' => $user->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
