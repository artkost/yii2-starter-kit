<?php

$items = [
    [
        'poster' => '<img src="http://anidesu.ru/sites/default/files/styles/news_poster_354x203/public/images/news/poster/1425722794/onepunch-man-4232221.jpg?itok=_5H9SU6W">',
        'title' => 'Аниме адаптации Onepunch-Man быть!',
        'content' => '<p>Радостная новость для фанатов манги <u>Onepunch-man </u>(<u>Ванпанчмен</u>), в свежем выпуске <em>Shueisha&nbsp;Young Jump</em>&nbsp;появилась заметка, что&nbsp;аниме адаптации быть! Пока никаких подробностей нету, обещают анонсировать промо видео и подробности кастинга на&nbsp;Anime Japan 2015, 21-22 марта.</p>',
        'date' => '2 дня 10 часов',
        'author' => 'edotensei',
    ],
    [
        'poster' => '<img src="http://anidesu.ru/sites/default/files/styles/news_poster_354x203/public/images/news/poster/1425721509/venus-project-like-wtf-another-idol-plis.jpg?itok=BoNOv81F">',
        'title' => 'Venus Project получит аниме этим летом',
        'content' => '<p>Радостная новость для фанатов манги <u>Onepunch-man </u>(<u>Ванпанчмен</u>), в свежем выпуске <em>Shueisha&nbsp;Young Jump</em>&nbsp;появилась заметка, что&nbsp;аниме адаптации быть! Пока никаких подробностей нету, обещают анонсировать промо видео и подробности кастинга на&nbsp;Anime Japan 2015, 21-22 марта.</p>',
        'date' => '2 дня 10 часов',
        'author' => 'edotensei',
    ],
    [
        'poster' => '<img src="http://anidesu.ru/sites/default/files/styles/news_poster_354x203/public/images/news/poster/1425546667/triagexanime_anidesu.ru_visual_news.jpg?itok=QIrrpmvj">',
        'title' => 'Triage X: подробности кастинга, дата премьеры и промо видео',
        'content' => '<p>Официальный сайт аниме адаптации сиськотрясной&nbsp;манги&nbsp;<u>Triage X</u> (<u>Отбор Икс</u>) опубликовал первое промо видео, дату премьеры и подробности кастинга. В видео можно посмотреть основных персонажей и завязку сюжета (если хорошо понимать английский).</p>',
        'date' => '2 дня 10 часов',
        'author' => 'edotensei',
    ]
]
?>

<?php foreach ($items as $item): ?>
    <?= $this->render('item', $item) ?>
<?php endforeach; ?>
