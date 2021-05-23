<?php

declare(strict_types=1);

namespace app\api\controller;

use app\common\logic\Upload as UploadLogic;

class Upload
{
    /**
     * 上传图片
     */
    public function image()
    {
        return UploadLogic::image('file');
    }
}
