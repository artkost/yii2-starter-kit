<?php

/**
 * Activation email view.
 *
 * @var \yii\web\View $this View
 * @var User $model Model
 */

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::toRoute(['/user/guest/activation', 'token' => $model['token']], true); ?>
<p>Здравствуйте <?= Html::encode($model['username']) ?>!</p>
<p>Перейдите по ссылке ниже чтобы подтвердить свой электронный адрес и активировать свой аккаунт:</p>
<p><?= Html::a(Html::encode($url), $url) ?></p>