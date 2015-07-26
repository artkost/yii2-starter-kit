<?php

/**
 * Error view.
 *
 * @var yii\base\View $this View
 * @var string $name Error name
 * @var string $message Error message
 * @var Exception $exception Exception
 */

use app\themes\admin\Theme;
use yii\helpers\Html;

$this->title = $name;
?>
<div class="error-page">
    <h2 class="headline text-red"><?= Html::encode($this->title); ?></h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> <?= Theme::t('error', 'Oops! Something went wrong.') ?></h3>
        <p>
            <?= Theme::t('error', 'We will work on fixing that right away.') ?>
            <?= Theme::t('error', 'Meanwhile, you may {dashboard} or try using the search form.', [
                'dashboard' => Html::a(Theme::t('error', 'return to dashboard'), ['/'])
            ]) ?>
        </p>
    </div>
</div><!-- /.error-page -->
