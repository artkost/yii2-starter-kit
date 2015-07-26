<?php
use app\assets\AppAsset;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html class="page" lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml"
      itemscope="itemscope" itemtype="http://schema.org/Product">
<head>
    <title><?= Html::encode(Yii::$app->name . ' :: ' . $this->title); ?></title>

    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <?= Html::csrfMetaTags(); ?>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta property="fb:app_id" content="APP_ID">
    <meta property="og:title" content="{{appName}} - {{title}}">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta property="og:url" content="APP_URL">
    <meta property="og:image" content="APP_LOGO">
    <meta property="og:site_name" content="MEAN - A Modern Stack">
    <meta property="fb:admins" content="APP_ADMIN">

    <?php $this->head() ?>

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<!-- BODY -->
<body class="page__body">
<?php $this->beginBody() ?>
<section class="layout">
    <section class="layout__container">
        <header class="layout__header header">
            <?= $this->render('parts/header') ?>
        </header>

        <div class="layout__center">

            <?php if (isset($this->blocks['header'])): ?>
                <section class="layout__section">
                    <?= $this->blocks['header'] ?>
                </section>
            <?php endif; ?>

            <section class="layout__section">
                <?php if (isset($this->blocks['sidebar'])): ?>
                    <main class="layout__main layout__section-main" role="main">
                        <div class="layout__section-main-inner">
                            <?= $content ?>
                        </div>
                    </main>

                    <aside class="layout__aside layout__section-aside">
                        <div class="layout__section-aside-inner">
                            <?= $this->blocks['sidebar'] ?>
                        </div>
                    </aside>
                <?php else: ?>
                    <?= $content ?>
                <?php endif; ?>
            </section>
        </div>
    </section>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
