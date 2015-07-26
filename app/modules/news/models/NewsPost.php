<?php

namespace app\modules\news\models;

use app\modules\page\models\Post;

class NewsPost extends Post
{
    public function attributes()
    {
        return [
            'id',
            'user_id',
            'title',
            'body',
            'raw',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    public function statusList()
    {
        return [
            'draft' => 'Draft',
            'published' => 'Published',
            'sticky' => 'Sticky',
        ];
    }
}