<?php
use yii\helpers\Url;
?>

<div class="layout__center header__inner">
    <div class="header__logo">
        <a class="header__logo-link" href="/"
           style="background: url('http://anidesu.ru/sites/default/themes/anidesu/logo.png');"></a>
    </div>
</div>

<div class="layout__center">
    <nav class="header__menu">
        <ul class="header__menu-list header__menu-list_mobile">
            <li class="header__menu-item">
                <a class="header__menu-link layout__toggle"><i class="fa fa-bars"></i></a>
            </li>
        </ul>
        <ul class="header__menu-list header__menu-list_main">
            <li class="header__menu-item">
                <a class="header__menu-link"
                   href="<?= Url::to(['/news/default/index']) ?>">Новости</a>
            </li>
            <li class="header__menu-item">
                <a class="header__menu-link"
                   href="<?= Url::to(['/film/default/index']) ?>">Аниме</a>
            </li>
        </ul>

        <div class="header__menu-search">

        </div>

        <div class="header__menu-actions">

            <a class="btn btn-default films__link-add" ui-sref="films add" title="Добавить фильм" href>
                <i class="fa fa-plus"></i>
            </a>

            <div class="ui buttons">
                <a class="ui button films__link-mode-list" href title="Список">
                    <i class="fa fa-list"></i>
                </a>

                <a class="ui button films__link-mode-thumb" href title="Картинки">
                    <i class="fa fa-th"></i>
                </a>

                <a class="ui button films__link-filter" href title="Show Filter">
                    <i class="fa fa-filter"></i>
                </a>
            </div>

            <span class="button">Вход</span>
        </div>
    </nav>
</div>
