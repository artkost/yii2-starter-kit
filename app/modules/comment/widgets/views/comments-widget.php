<section class="comments-widget">
    <header class="comments-widget__header"></header>

    <section class="comments-widget__list">
        <?php foreach (array(1,2,3,4,5,6) as $item): ?>
        <div class="comments-widget__item">
            <div class="comments-widget__avatar">
                <a class="comments-widget__avatar-link" href="#">
                    <img class="comments-widget__avatar-img"
                         src="http://anidesu.ru/sites/default/files/styles/avatar_70x70/public/pictures/picture-543-1415353345.gif?itok=bEuotstn"
                         alt=""/>
                </a>

                <a class="comments-widget__author-like"><i class="fa fa-heart"></i></a>
                <div class="comments-widget__author-like-count"><?= rand(1, 123) ?></div>
            </div>
            <div class="comments-widget__body">
                <div class="comments-widget__author">
                    <a class="comments-widget__author-name" href="#">Netero</a>
                    <span class="comments-widget__author-date">2 дня назад</span>

                    <a class="comments-widget__action comments-widget__action-delete" href="#" title="Удалить"><i class="fa fa-close"></i></a>
                    <a class="comments-widget__action comments-widget__action-edit" href="#" title="Редактировать"><i class="fa fa-pencil"></i></a>
                </div>
                <div class="comments-widget__content">
                    Есть что посмотреть, трэща не очень уж много, эх блин придётся ждать долго(люблю целиком смотреть,а не по сериям). P.S.Что за аниме манга на обложке поста? Подскажите.
                </div>
                <div class="comments-widget__actions">

                    <a class="comments-widget__action comments-widget__action-answer page__link" href="#">Ответить</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="comments-widget__item comments-widget__item_type_more">
            <a class="comments-widget__more-link" href="#"><i class="fa fa-comment"></i> показать еще <?= rand(2, 23) ?> комментариев</a>
        </div>
    </section>

    <footer class="comments-widget__add">

        <div class="comments-widget__add-avatar">
            <img class="comments-widget__add-avatar-img"
                 src="http://anidesu.ru/sites/default/files/styles/avatar_70x70/public/pictures/picture-543-1415353345.gif?itok=bEuotstn"
                 alt=""/>
        </div>

        <div class="comments-widget__add-form">
            <form action="#">
                <span class="comments-widget__add-textarea form-input form-input_type_textarea">
                    <textarea class="form-input__field" name="comment" id="comment" placeholder="Напишите комментарий"></textarea>
                </span>
            </form>
        </div>

    </footer>
</section>
