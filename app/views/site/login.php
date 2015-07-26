<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="login col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

    <h1 class="page__h1">Login</h1>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'login-form'],
        'fieldConfig' => [

        ],
    ]); ?>

    <?= $form->field($model, 'username')->label(false); ?>

    <?= $form->field($model, 'password')->passwordInput()->label(false); ?>

    <?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>

    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>