<?php

namespace app\modules\user\models;

use artkost\attachment\models\ImageFile;

class UserAvatarFile extends ImageFile
{
    const TYPE = 'user_profile';

    public $path = 'user/profile';
}
