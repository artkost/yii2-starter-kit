<?php

namespace app\modules\comment\widgets;

use yii\base\Widget;

class CommentsWidget extends Widget
{
    public function run()
    {
        return $this->render('comments-widget');
    }
}
