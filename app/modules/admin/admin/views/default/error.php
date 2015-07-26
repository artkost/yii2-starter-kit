<?php

/**
 * Error view.
 *
 * @var yii\base\View $this View
 * @var string $name Error name
 * @var string $message Error message
 * @var Exception $exception Exception
 */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="site-error container">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)); ?>
    </div>
</div>
