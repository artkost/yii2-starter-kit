<?php

/**
 * Sign In page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\modules\user\forms\Login $model Model
 */

use app\modules\user\Module;
use app\themes\admin\assets\ICheckAsset;
use app\themes\admin\Theme;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Theme::t('title', 'Login');
$this->context->layout = '//login';
?>

<p class="login-box-msg"><?= Theme::t('user', 'Sign in to start your session') ?></p>
<?php $form = ActiveForm::begin(); ?>
    <div class="form-group has-feedback">
        <?= $form
            ->field($model, 'username')
            ->textInput([
                'placeholder' => $model->getAttributeLabel('username')
            ])->label(false) ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <?= $form
            ->field($model, 'password')
            ->passwordInput([
                'placeholder' => $model->getAttributeLabel('password')
            ])->label(false) ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <?= $form->field($model, 'rememberMe')
                    ->checkbox()->label(false) ?>
            </div>
        </div><!-- /.col -->
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
                <?= Theme::t('user', 'Login') ?>
            </button>
        </div><!-- /.col -->
    </div>
<?php ActiveForm::end(); ?>

<a href="<?= Url::to(['/user/default/recovery']) ?>"><?= Theme::t('user', 'I forgot my password') ?></a>
<?php

ICheckAsset::register($this);

$js = <<<JS
$('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
});
JS;

$this->registerJs($js);

?>
