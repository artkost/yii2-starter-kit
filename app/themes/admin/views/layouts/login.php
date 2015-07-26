<?php

/**
 * Theme layout for guests.
 *
 * @var \yii\web\View $this View
 * @var string $content Content
 */

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->render('head') ?>
</head>
<body class="login-page">
<?php $this->beginBody(); ?>
<div class="login-box">
    <div class="login-logo">
        <a href="<?= Yii::$app->homeUrl ?>"><b>Admin</b> <?= Yii::$app->name ?></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?= $content ?>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

