<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */
?>
<?php $this->beginPage() ?>
<!doctype html>
<html>
<head>
    <?= $this->render('head') ?>
</head>
<!-- BODY -->
<body class="page__body">
<?php $this->beginBody() ?>

<div class="demo-blog mdl-layout mdl-js-layout has-drawer is-upgraded">
    <main class="mdl-layout__content">
        <?= $content ?>

        <footer class="mdl-mini-footer">
            <div class="mdl-mini-footer--left-section">
                <button class="mdl-mini-footer--social-btn social-btn social-btn__twitter"></button>
                <button class="mdl-mini-footer--social-btn social-btn social-btn__blogger"></button>
                <button class="mdl-mini-footer--social-btn social-btn social-btn__gplus"></button>
            </div>
            <div class="mdl-mini-footer--right-section">
                <button class="mdl-mini-footer--social-btn social-btn__share"><i class="material-icons">share</i></button>
            </div>
        </footer>
    </main>
    <div class="mdl-layout__obfuscator"></div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
