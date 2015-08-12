<?php

namespace app\modules\comment;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    const PARAM_ROOT = 'film';
    const TRANSLATE_CATEGORY = 'film';

    use ModuleParamTrait;
    use TranslatableTrait;

    /**
     * @var array of models added by default in migrations
     */
    public $defaultModels = [];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        $app->i18n->translations['comment/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/modules/comment/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'comment/comment' => 'comment.php',
                'comment/model' => 'model.php',
                'comment/admin' => 'admin.php',
            ]
        ];
    }
} 
