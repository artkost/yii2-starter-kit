<?php

return [
    'permissions' => [
        'commentView' => 'View Comment',
        'commentCreate' => 'Create Comment',
        'commentUpdate' => 'Update Comment',
        'commentDelete' => 'Delete Comment',
        'commentUpdateOwn' => 'Update Own Comment',
        'commentDeleteOwn' => 'Delete Own Comment'
    ],
    'roles' => [
        'commentReader' => 'Comment Reader',
        'commentWriter' => 'Comment Writer',
        'commentManager' => 'Comment Manager',
    ],
    'assignments' => [
        'commentReader' => ['commentView'],
        'commentWriter' => ['commentCreate', 'commentUpdateOwn', 'deleteOwnComment'],
        'commentManager' => ['commentWriter', 'commentUpdate', 'commentDelete'],
        'guest' => ['commentReader']
    ]
];