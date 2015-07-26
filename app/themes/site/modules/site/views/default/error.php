<?php

use app\themes\site\Theme;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

$this->title = $name;
?>

<div class="demo-blog__posts mdl-grid">
    <div class="mdl-card mdl-cell mdl-cell--8-col">
        <div class="mdl-card__media mdl-color-text--grey-50">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="mdl-card__supporting-text mdl-color-text--grey-600">
            <p><?= nl2br(Html::encode($message)) ?></p>
            <p><?= Theme::t('error', 'The above error occurred while the Web server was processing your request.') ?></p>
            <p><?= Theme::t('error', 'Please contact us if you think this is a server error. Thank you.') ?></p>
        </div>
    </div>
</div>
