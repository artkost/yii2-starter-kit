<?php

/**
 * Recovery password page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\modules\user\forms\Recovery $model Model
 */

use app\modules\user\Module;
use app\themes\admin\Theme;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Theme::t('title', 'Password Recovery');
$this->context->layout = '//login';
?>

<p class="login-box-msg"><?= Html::encode($this->title); ?></p>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'email')
    ->textInput([
        'placeholder' => $model->getAttributeLabel('email')
    ])->label(false) ?>

<div class="row">
    <div class="col-xs-4">
        <a href="<?= Url::to(['login']) ?>" class="btn btn-default btn-flat">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= Theme::t('user', 'Use login') ?>
        </a>
    </div><!-- /.col -->
    <div class="col-xs-8">
        <?= Html::submitButton(Theme::t('user', 'Recover password'), ['class' => 'btn bg-olive btn-block btn-flat']) ?>
    </div><!-- /.col -->
</div>
<?php ActiveForm::end(); ?>
