<?php

/**
 * Comments list view.
 *
 * @var \yii\web\View $this View
 * @var \app\modules\comment\models\Comment[] $models Comments models
 * @var \app\modules\comment\models\Comment $model New comment model
 * @var string $route route to create comment
 */

use app\modules\comment\Module;
use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user;
?>

<div id="comments" class="comments">
    <div id="comments-list" class="comments__list" data-comment="list">
        <?php if ($user->can('commentView')): ?>
            <?= $this->render('_index_item', ['models' => $models]) ?>
        <?php endif; ?>
    </div>

    <div class="well comments__form">
        <?php if ($user->can('commentCreate')) : ?>
            <h3><?= Module::t('comment', 'Post comment') ?></h3>
            <?= $this->render('_form', ['model' => $model, 'route' => $route]); ?>
        <?php else: ?>
            <?= Module::t('comment', '<a href="{login}">Login</a> or <a href="{register}">register</a> to post comments', [
                'login' => Url::to($user->loginUrl),
                'register' => Url::to(['/user/guest/signup'])
            ]) ?>
        <?php endif; ?>
    </div>
</div>