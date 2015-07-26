<?php

/**
 * Comments item view.
 *
 * @var \yii\web\View $this View
 * @var \app\modules\comment\models\Comment[] $models Comments models
 */

use app\modules\comment\Module;
use yii\helpers\Url;

$user = Yii::$app->user;

?>
<?php if ($models !== null) : ?>
    <?php foreach ($models as $comment) : ?>
        <div class="media comment" data-comment="parent" data-comment-id="<?= $comment->id ?>">
            <div class="media-left">
                <img src="<?= $comment->authorAvatarUrl ?>" class="avatar img-circle width-50" alt="<?= $comment->author->profile->fullName ?>"/>
            </div>
            <div class="media-body comment__body">
                <div class="comment__content" data-comment="append">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="media-heading">
                                <strong><?= $comment->author->fullName ?></strong>&nbsp;
                                <small><?= $comment->created ?></small>
                                <?php if ($comment->parent_id): ?>
                                    &nbsp;
                                    <a href="#comment-<?= $comment->parent_id ?>" data-comment="ancor" data-comment-parent="<?= $comment->parent_id ?>"><i class="icon-arrow-up"></i></a>
                                <?php endif; ?>

                            </div>
                            <?php if ($comment->isDeleted) { ?>
                                <?= Module::t('comment', 'FRONTEND_WIDGET_COMMENTS_DELETED_COMMENT_TEXT') ?>
                            <?php } else { ?>
                                <div class="content" data-comment="content"><?= $comment->content ?></div>
                            <?php } ?>
                        </div>

                        <?php if ($comment->isActive &&
                            (
                                $user->can('commentCreate') ||
                                $user->can('commentUpdate') ||
                                $user->can('commentUpdateOwn', ['model' => $comment]) ||
                                $user->can('commentDelete') ||
                                $user->can('commentDeleteOwn', ['model' => $comment])
                            )
                        ): ?>
                            <div class="panel-footer">
                                <div class="comment__actions" data-comment="tools">
                                    <span class="btn-group btn-group-xs ">
                                        <?php if ($user->can('commentCreate')) { ?>
                                            <span class="btn btn-default" data-comment="reply"
                                                  data-comment-id="<?= $comment->id ?>">
                                                <i class="icon-repeat"></i> <?= Module::t('comment', 'FRONTEND_WIDGET_COMMENTS_REPLY') ?>
                                            </span>
                                        <?php } ?>
                                        <?php if ($user->can('commentUpdate') || $user->can('commentUpdateOwn', ['model' => $comment])) { ?>
                                            &nbsp;
                                            <span class="btn btn-default" data-comment="update"
                                                  data-comment-id="<?= $comment->id ?>" data-comment-url="<?= Url::to([
                                                '/comment/default/update',
                                                'id' => $comment->id
                                            ]) ?>">
                                                <i class="icon-pencil"></i> <?= Module::t('comment', 'FRONTEND_WIDGET_COMMENTS_UPDATE') ?>
                                            </span>
                                        <?php } ?>
                                        <?php if ($user->can('commentDelete') || $user->can('commentDeleteOwn', ['model' => $comment])) { ?>
                                            &nbsp;
                                            <span class="btn btn-default" data-comment="delete"
                                                  data-comment-id="<?= $comment->id ?>" data-comment-url="<?= Url::to([
                                                '/comment/default/delete',
                                                'id' => $comment->id
                                            ]) ?>"
                                                  data-comment-confirm="<?= Module::t('comment', 'FRONTEND_WIDGET_COMMENTS_DELETE_CONFIRMATION') ?>">
                                                <i class="icon-trash"></i> <?= Module::t('comment', 'FRONTEND_WIDGET_COMMENTS_DELETE') ?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <?php if ($comment->children) { ?>
                    <?= $this->render('_index_item', ['models' => $comment->children]) ?>
                <?php } ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>