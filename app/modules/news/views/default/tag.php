<?php

$this->title = 'Новости по тегу Новости';

?>
<div class="layout__block">
    <div class="layout__block-inner">
        <h1 class="page__h1"><?= $this->title ?></h1>

        <div class="news">
            <div class="news__list"><?= $this->render('parts/list') ?></div>
        </div>
    </div>
</div>
