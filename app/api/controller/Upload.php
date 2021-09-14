<?php

declare(strict_types=1);

namespace app\api\controller;

use app\common\logic\Upload as UploadLogic;

/**
 * 上传文件
 */
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
