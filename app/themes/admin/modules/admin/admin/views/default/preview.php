<?php
use app\modules\admin\Module;
use app\themes\admin\Theme;
use app\themes\admin\widgets\Box;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var $modules array
 */

$this->title = Theme::t('title', 'Admin');
$this->params['subtitle'] = Theme::t('title', 'Site Preview');
$this->params['breadcrumbs'] = [
    $this->title
];

$site = Module::param('site.url', str_replace(ADMIN_PREFIX, '', Url::base(true)));

$js = <<<JS
    jQuery(function($) {
        var iframe = $('iframe#sitepreview');

        iframe.load(function () {
            var ifcontent = iframe.contents();
            console.log('ifheight', iframe[0].contentWindow);
            iframe.height(ifcontent.height());
        });
    });
JS;

$this->registerJs($js);
?>
<div class="row"><div class="col-xs-12">
<?php
Box::begin(
    [
        'title' => $this->params['subtitle'],
        'bodyOptions' => ['class' => 'no-padding']
    ]
);
?>
<iframe src="<?= $site ?>" id="sitepreview" frameborder="0" width="100%" height="2048px"></iframe>
<?php Box::end(); ?>
</div></div>

