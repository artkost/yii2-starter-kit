<?php

use yii\helpers\Url;

$route = Url::to(['/news/default/view', 'url' => 'asdasd']);
?>

<div class="news-item">
    <section class="news-item__body">
        <div class="news-item__poster">
            <a class="news-item__poster-link" href="<?= $route ?>">
                <?= $poster ?>
            </a>
        </div>
        <div class="news-item__content">
            <h3 class="news-item__title">
                <a class="news-item__title-link page__link" href="<?= $route ?>"><?= $title ?></a>
            </h3>
            <?= $content ?>
        </div>
    </section>
    <footer class="news-item__meta layout__block-wide">
        <div class="news-item__meta-item news-item__date"><?= $date ?></div>
        <div class="news-item__meta-item news-item__author"><a class="page__link" href="#"><?= $author ?></a></div>
    </footer>
</div>
