<?php
/**
 * @var $this \yii\web\View
 */

$this->title = 'Новости'

?>
<div class="layout__block">
    <div class="layout__block-inner">
        <h1 class="page__h1"><?= $this->title ?></h1>

        <div class="news">
            <div class="news__list"><?= $this->render('parts/list') ?></div>
        </div>
    </div>
</div>

<?php $this->beginBlock('sidebar') ?>
    <div class="layout__block">
        <div class="layout__block-inner">
            <div class="block-tabs layout__block-full">
                <div class="block-tabs__items">
                    <div class="block-tabs__tab-name block-tabs__tab_state_current">Топ Аниме</div>
                    <div class="block-tabs__tab-name">Топ Новости</div>
                </div>
                <div class="block-tabs__tab-body block-tabs__tab_state_current"></div>
                <div class="block-tabs__tab-body"></div>
            </div>
        </div>
    </div>
<?php $this->endBlock() ?>
